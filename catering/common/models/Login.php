<?php

namespace common\models;

use common\models\Employee;
use Yii;
use yii\base\Model;

class Login extends Model
{
    public $login;
    public $pass;

    public function rules()
    {
        return [
            [['login','pass'], 'string'],
            [['login','pass'], 'trim'],
            [['login','pass'], 'required', 'message' => 'Обязательное поле'],
            ['pass', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Введите логин',
            'pass' => 'Введите пароль',
        ];
    }

    public function login()
    {
        if (!$this->validate())
        {
            return $this->getErrors();
        }
        else {
            $user = Employee::findOne(['login' => $this->login]);
            $token = Yii::$app->security->generateRandomString();
            Yii::$app->db->createCommand()->update('employee', ['token' => $token], 'id='.$user->id)
                ->execute();
            return $token;
        }
    }

    public function validatePassword($attribute, $params)
    {
        $employee = Employee::findByUsername($this->login);
        if (!$employee || !$employee->validatePassword($this->pass)) {
            $this->addError($attribute, 'Неверный логин или пароль');
        }
    }
}