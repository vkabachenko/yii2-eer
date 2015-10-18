<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use bupy7\ajaxfilter\AjaxFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            [
                'class' => AjaxFilter::className(),
                'actions' => ['year'],
            ],
        ];
    }

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
