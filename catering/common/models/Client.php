<?php


namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Client extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%client}}';
    }

    public function rules()
    {
        return [
            [['name', 'surname', 'type', 'birth_date', 'telephone', 'email'], 'required', 'message' => 'Обязательное поле'],
            [['name', 'surname', 'fathername', 'telephone'], 'string', 'max' => 128],
            [['type'], 'string', 'max' => 12],
            [['date_added'], 'safe'],
            [['date_added'], 'date', 'format' => 'php:d.m.Y'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'fathername' => 'Отчество',
            'surname' => 'Фамилия',
            'type' => 'Тип клиента',
            'birth_date' => 'Дата рождения',
            'telephone' => 'Телефон',
            'email' => 'E-mail',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if(parent::afterSave($insert, $changedAttributes)) {
            $this->date_added = date();
        }
    }
}
