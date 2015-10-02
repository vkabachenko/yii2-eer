<?php

namespace backend\modules\discipline\controllers;

use common\models\Program;
use Yii;
use common\models\Discipline;
use common\models\DisciplineName;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class MainController extends GridController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'][0]['actions'][] = 'create-additive';

        return $behaviors;
    }


    public function init() {

        $this->_model = 'common\models\DisciplineName';
        $this->_idParentName = 'id_program_main';

    }

    protected function createProvider($query) {

        /* @var $query \yii\db\ActiveQuery */
        /* @var $provider ActiveDataProvider */

        $subQuery = Discipline::find()->
                    select('*,
                          cast([[code_last]] as decimal(10,3)) as [[code_last_num]]');
        $query->innerJoin(['main' => $subQuery], 'main.id = id_discipline');


        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $provider->setSort([
            'attributes' => [
                'name',
                'disciplineCode'=>[
                    'asc' => ['main.code_first' => SORT_ASC,
                              'main.code_last_num' => SORT_ASC,
                              'suffix' => SORT_ASC],
                    'desc' => ['main.code_first' => SORT_DESC,
                               'main.code_last_num' => SORT_DESC,
                               'suffix' => SORT_DESC],
                    'label'=>'DisciplineCode',
                ]
            ],
            'defaultOrder' => ['disciplineCode' => SORT_ASC,]
        ]);


        return $provider;

    }

    /**
     * Новая модель discipline и связанная с ней новая модель discipline_name
     * @return mixed
     */
    public function actionCreate($idParent = null)
    {
        /* @var $discipline Discipline */
        /* @var $disciplineName DisciplineName */

        $discipline = new Discipline();
        $disciplineName = new DisciplineName();

        $discipline->id_program = $idParent;
        $disciplineName->id_program_main = $idParent;

        if ($discipline->load(Yii::$app->request->post()) && $discipline->save()) {
            $disciplineName->load(Yii::$app->request->post());
            $disciplineName->id_discipline = $discipline->id;
            $disciplineName->save();
            return 'Item is succesfully created.'; // alert message
        } else {
            return $this->renderAjax('update', [
                'discipline' => $discipline,
                'disciplineName' => $disciplineName,
            ]);
        }
    }

    /**
     * Дополнительная модель discipline_name
     * к существующей модели discipline
     * @return mixed
     */
    public function actionCreateAdditive($idParent)
    {
        /* @var $disciplines array */
        /* @var $disciplineName DisciplineName */

        $disciplines = Discipline::find()->
            where(['block' => Discipline::DISCIPLINE_CHOICE])->
            select(['id',"concat([[code_first]],'.',[[code_last]]) as code"])->
            orderBy('cast([[code_last]] as unsigned)')->asArray()->all();
        $disciplines = ArrayHelper::map($disciplines,'id','code');

        $disciplineName = new DisciplineName();
        $disciplineName->id_program_main = $idParent;
        if ($disciplineName->load(Yii::$app->request->post()) && $disciplineName->save()) {
            return 'Item is succesfully created.'; // alert message
        } else {
            return $this->renderAjax('updateAdditive', [
                'disciplines' => $disciplines,
                'disciplineName' => $disciplineName,
            ]);
        }
    }

    /**
     * Updates an existing  model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /* @var $disciplineName DisciplineName */
        /* @var $discipline Discipline */
        $disciplineName = $this->findModel($id);
        $discipline = $disciplineName->idDiscipline;

        if ($disciplineName->load(Yii::$app->request->post()) && $disciplineName->save()) {
            $discipline->load(Yii::$app->request->post());
            $discipline->save();
            return '';
        } else {
            return $this->renderAjax('update', [
                'discipline' => $discipline,
                'disciplineName' => $disciplineName,
            ]);
        }
    }


    protected function getIdFaculty($id, $parent = false) {

        if ($parent) {
            $model = Program::findOne($id);
            return $model->id_faculty;
         }
        else {
            $model = DisciplineName::findOne($id);
            return $model->idProgram->id_faculty;
        }
    }


}
