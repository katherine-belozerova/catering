<?php


namespace frontend\controllers;

use common\models\Client;
use common\models\Organization;
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
        $n = Client::find()
            ->count();
        $k = 1;
        $names = Client::find()->select('name')->all();
        $surnames = Client::find()->select('surname')->all();
        $fathernames = Client::find()->select('fathername')->all();
        $types = Client::find()->select('type')->all();
        $birth_dates = Client::find()->select('birth_date')->all();
        $telephones = Client::find()->select('telephone')->all();
        $emails = Client::find()->select('email')->all();
        $organization_ids = Client::find()->select('organization_id')->all();
        for($i=0;$i<$n;$i++) {
            $clients[$k] = [
                "organization_id" => $organization_ids[$i],
                "organization" => Organization::find()
                    ->select('name')
                    ->where(['organization_id' => $organization_ids[$i]]),
                "surname" => $surnames[$i],
                "name" => $names[$i],
                "fathername" => $fathernames[$i],
                "type" => $types[$i],
                "birth_date" => $birth_dates[$i],
                "telephone" => $telephones[$i],
                "email" => $emails[$i],
            ];
            $k++;
        }
        return $clients;
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

        if ($model->surname !== $surname) {
            Yii::$app->db->createCommand()
                ->update('client', ['surname' => $surname], 'id=' . $model->id)
                ->execute();
        }
        if ($model->name !== $name) {
            Yii::$app->db->createCommand()
                ->update('client', ['name' => $name], 'id=' . $model->id)
                ->execute();
        }
        if ($model->fathername !== $fathername) {
            Yii::$app->db->createCommand()
                ->update('client', ['fathername' => $fathername], 'id=' . $model->id)
                ->execute();
        }
        if ($model->type !== $type) {
            Yii::$app->db->createCommand()
                ->update('client', ['type' => $type], 'id=' . $model->id)
                ->execute();
        }
        if ($model->birth_date !== $birth_date) {
            Yii::$app->db->createCommand()
                ->update('client', ['birth_date' => $birth_date], 'id=' . $model->id)
                ->execute();
        }
        if ($model->telephone !== $telephone) {
            Yii::$app->db->createCommand()
                ->update('client', ['telephone' => $telephone], 'id=' . $model->id)
                ->execute();
        }
        if ($model->email !== $email) {
            Yii::$app->db->createCommand()
                ->update('client', ['email' => $email], 'id=' . $model->id)
                ->execute();
        }
        if ($model->organization_id !== $organization_id) {
            Yii::$app->db->createCommand()
                ->update('client', ['organization_id' => $organization_id], 'id=' . $model->id)
                ->execute();
        }
    }
}