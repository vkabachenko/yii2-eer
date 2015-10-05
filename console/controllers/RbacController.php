<?php

namespace console\controllers;

use common\rbac\UserFacultyRule;
use common\rbac\UserStudentRule;
use common\rbac\UserProgramFilesRule;
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
       $viewProgramFiles = $auth->createPermission('viewProgramFiles');
       $updateStudent = $auth->createPermission('updateStudent');

       // правила
       $roleRule = new UserRoleRule();
       $facultyRule = new UserFacultyRule();
       $studentRule = new UserStudentRule();
       $programFilesRule = new UserProgramFilesRule();

       // Добавляем все в authManager
       $auth->add($student);
       $auth->add($inspector);
       $auth->add($localAdmin);
       $auth->add($admin);

       $auth->add($updateFaculty);
       $auth->add($viewFaculty);
       $auth->add($viewProgramFiles);
       $auth->add($createDeleteFaculty);
       $auth->add($updateStudent);

       $auth->add($roleRule);
       $auth->add($facultyRule);
       $auth->add($studentRule);
       $auth->add($programFilesRule);

       // добавляем правила в роли и разрешения
       $student->ruleName = $roleRule->name;
       $inspector->ruleName = $roleRule->name;
       $localAdmin->ruleName = $roleRule->name;
       $admin->ruleName = $roleRule->name;

       $updateFaculty->ruleName = $facultyRule->name;
       $viewFaculty->ruleName = $facultyRule->name;
       $updateStudent->ruleName = $studentRule->name;
       $viewProgramFiles->ruleName = $programFilesRule->name;

       // иерархия разрешений
       $auth->addChild($student,$updateStudent);
       $auth->addChild($student,$viewProgramFiles);

       $auth->addChild($inspector,$viewFaculty);
       $auth->addChild($inspector,$viewProgramFiles);

       $auth->addChild($localAdmin,$updateFaculty);
       $auth->addChild($localAdmin,$viewFaculty);
       $auth->addChild($localAdmin,$viewProgramFiles);


       $auth->addChild($admin,$createDeleteFaculty);
       $auth->addChild($admin,$updateFaculty);
       $auth->addChild($admin,$viewFaculty);
       $auth->addChild($admin,$viewProgramFiles);

   }

} 