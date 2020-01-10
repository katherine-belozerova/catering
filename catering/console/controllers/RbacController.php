<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $director = $auth->createRole('director');
        $auth->add($director);

        $manager = $auth->createRole('manager');
        $auth->add($manager);

        $updateEmployee = $auth->createPermission('updateEmployee');
        $updateEmployee->description = 'Редактировать информацию о сотруднике';

        $createEmployee = $auth->createPermission('createEmployee');
        $createEmployee->description = 'Зарегистрировать сотрудника';

        $viewEmployee = $auth->createPermission('viewEmployee');
        $viewEmployee->description = 'Просмотр сотрудников';

        $auth->add($updateEmployee);
        $auth->add($createEmployee);
        $auth->add($viewEmployee);

        $auth->assign($admin, 1);

        $auth->addChild($director, $viewEmployee);
        $auth->addChild($admin, $director);
        $auth->addChild($admin, $createEmployee);
        $auth->addChild($admin, $updateEmployee);
        $auth->addChild($admin, $manager);

        $this->stdout('Выполнено' . PHP_EOL);
    }
}
