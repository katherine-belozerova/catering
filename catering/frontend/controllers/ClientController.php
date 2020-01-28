<?php


namespace frontend\controllers;

use common\models\Client;
use yii\filters\AccessControl;

class ClientController extends ApiController
{
    public $modelClass = Client::class;

    protected function verbs()
    {
        return [
            'create' => ['POST', 'OPTIONS'],
        ];
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'denyCallback' => function ($rule, $action)
            {
                throw new \Exception('У Вас нет прав для доступа к данной странице');
            },
            'rules' => [

                [
                    'actions' => ['sort-by', 'create', 'edit', 'list', 'delete', 'update', 'view', 'index'],
                    'allow' => false,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['sort-by', 'create', 'edit', 'list', 'delete'],
                    'allow' => true,
                    'roles' => ['manager'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionSortBy($sort)
    {
        $sorting = Client::find()
            ->orderBy([$sort => SORT_ASC])
            ->all();
        return $sorting;
    }

    public function actionList()
    {
        $client = Client::find()
            ->orderBy(['id' => SORT_DESC])
            ->all();
        return $client;
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        $name = Yii::$app->getRequest()->getBodyParam('name');
        $surname = Yii::$app->getRequest()->getBodyParam('surname');
        $fathername = Yii::$app->getRequest()->getBodyParam('fathername');
        $type = Yii::$app->getRequest()->getBodyParam('type');
        $birth_date = Yii::$app->getRequest()->getBodyParam('birth_date');
        $telephone = Yii::$app->getRequest()->getBodyParam('telephone');
        $email = Yii::$app->getRequest()->getBodyParam('email');
        $organization_id = Yii::$app->getRequest()->getBodyParam('organization_id');

        if (($model->surname !== $surname)
            && (Client::find()
                    ->where(['inn' => $inn])
                    ->count() == 0)) {
            Yii::$app->db->createCommand()
                ->update('organization', ['inn' => $inn], 'id=' . $model->id)
                ->execute();
        } elseif (($model->inn !== $inn)
            && (Client::find()
                    ->where(['inn' => $inn])
                    ->count() > 0)) {
            return "Данный ИНН уже используется";
        }
        if ($model->name !== $name) {
            Yii::$app->db->createCommand()
                ->update('organization', ['name' => $name], 'id=' . $model->id)
                ->execute();
        }
        if ($model->address !== $address) {
            Yii::$app->db->createCommand()
                ->update('organization', ['address' => $address], 'id=' . $model->id)
                ->execute();
        }
    }
}