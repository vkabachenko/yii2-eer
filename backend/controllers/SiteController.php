<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'year' => 'common\actions\YearAction',
            'login' => 'common\actions\LoginAction',
            'logout' => 'common\actions\LogoutAction',

        ];
    }

    public function actionIndex()
    {
       if (Yii::$app->user->can('updateFaculty')) {
            $this->redirect(['/faculty/main/index']);
        }

       elseif (Yii::$app->user->can('updateStudent')) {
            $this->redirect(['/student/portfolio/index',
                'id' => Yii::$app->user->identity->id_student]);
        }
        else {
            $this->redirect(['login']);
        }
    }

}
