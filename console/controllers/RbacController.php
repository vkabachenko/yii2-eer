<?php

namespace console\controllers;

use common\rbac\UserFacultyRule;
use common\rbac\UserStudentRule;
use Yii;
use yii\console\Controller;
use common\rbac\UserRoleRule;

class RbacController extends Controller {

   public function actionInit() {

       $auth = Yii::$app->authManager;
       $auth->removeAll(); //удаляем старые данные

       // роли
       $student = $auth->createRole('student');
       $inspector = $auth->createRole('inspector');
       $localAdmin = $auth->createRole('localAdmin');
       $admin = $auth->createRole('admin');

       // разрешения
       $createDeleteFaculty = $auth->createPermission('createDeleteFaculty');
       $updateFaculty = $auth->createPermission('updateFaculty');
       $viewFaculty = $auth->createPermission('viewFaculty');
       $updateStudent = $auth->createPermission('updateStudent');

       // правила
       $roleRule = new UserRoleRule();
       $facultyRule = new UserFacultyRule();
       $studentRule = new UserStudentRule();

       // Добавляем все в authManager
       $auth->add($student);
       $auth->add($inspector);
       $auth->add($localAdmin);
       $auth->add($admin);

       $auth->add($updateFaculty);
       $auth->add($viewFaculty);
       $auth->add($createDeleteFaculty);
       $auth->add($updateStudent);

       $auth->add($roleRule);
       $auth->add($facultyRule);
       $auth->add($studentRule);

       // добавляем правила в роли и разрешения
       $student->ruleName = $roleRule->name;
       $inspector->ruleName = $roleRule->name;
       $localAdmin->ruleName = $roleRule->name;
       $admin->ruleName = $roleRule->name;

       $updateFaculty->ruleName = $facultyRule->name;
       $viewFaculty->ruleName = $facultyRule->name;
       $updateStudent->ruleName = $studentRule->name;

       // иерархия разрешений
       $auth->addChild($student,$updateStudent);
       $auth->addChild($inspector,$viewFaculty);
       $auth->addChild($localAdmin,$updateFaculty);
       $auth->addChild($admin,$createDeleteFaculty);

       //иерархия ролей
       $auth->addChild($localAdmin,$inspector);
       $auth->addChild($admin,$localAdmin);
       $auth->addChild($admin,$student);

   }

} 