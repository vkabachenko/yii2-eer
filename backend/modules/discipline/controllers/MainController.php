<?php

namespace backend\modules\discipline\controllers;

use Yii;
use common\models\Discipline;
use common\models\DisciplineName;
use backend\controllers\GridController;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class MainController extends GridController
{

    public function init() {

        $this->_model = 'common\models\DisciplineName';
        $this->_idParentName = 'id_program_main';

    }

    protected function createProvider($query) {

        /* @var $query \yii\db\ActiveQuery */
        /* @var $provider ActiveDataProvider */
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
                    'asc' => ['discipline.code' => SORT_ASC,'suffix' => SORT_ASC],
                    'desc' => ['discipline.code' => SORT_DESC,'suffix' => SORT_DESC],
                    'label'=>'DisciplineCode',
                ]
            ],
            'defaultOrder' => ['disciplineCode' => SORT_ASC,]
        ]);

        $query->joinWith(['idDiscipline']); // для сортировки по disciplineCode

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
            orderBy('code')->asArray()->all();
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


}
