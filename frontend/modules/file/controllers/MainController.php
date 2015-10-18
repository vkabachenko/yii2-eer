<?php


namespace frontend\modules\file\controllers;

use common\models\DisciplineName;
use common\models\StudentResult;
use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use common\models\User;
use bupy7\ajaxfilter\AjaxFilter;


class MainController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            [
                'class' => AjaxFilter::className(),
                'actions' => ['program', 'discipline','result'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'download' => 'common\actions\DownloadAction',
        ];
    }

    public function actionProgram($id)
    {

        $allowed = Yii::$app->user->can('viewProgramFiles',['id_program' => $id]);

        return $this->renderFiles('common\models\Program', $id, $allowed);

    }

    public function actionDiscipline($id)
    {
        $id_program = DisciplineName::findOne($id)->idProgram->id;
        $allowed = Yii::$app->user->can('viewProgramFiles',['id_program' => $id_program]);

        return $this->renderFiles('common\models\DisciplineName', $id, $allowed);

    }

    public function actionResult($id)
    {
        $result = StudentResult::findOne($id);

        if (Yii::$app->user->identity->role == User::ROLE_STUDENT) {
            $allowed = Yii::$app->user->can('updateStudent',
                ['id_student' => $result->idStudentEducation->idStudent->id]);
        }
        else {
            $allowed = Yii::$app->user->can('viewProgramFiles',
                ['id_program' => $result->idDisciplineSemester->idDiscipline->id_program]);
        }

        return $this->renderFiles('common\models\StudentResult', $id, $allowed);

    }

    private function renderFiles($_model, $id, $allowed)
    {

        /* @var $model \yii\db\ActiveRecord */
        $model = new $_model;
        $fileQuery = $model->findOne($id)->getFiles();

        if (!$allowed) {
            $fileQuery->andWhere(['free_access' => 1]);
        }

        $files = $fileQuery->all();

        $provider = new ArrayDataProvider([
            'allModels' => $files,
            'sort' => [
                'attributes' => ['title'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->renderPartial('list',['provider' => $provider]);
    }

} 