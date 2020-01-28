<?php

namespace common\models;

use yii\db\ActiveRecord;


class Organization extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%organization}}';
    }

    public function rules()
    {
        return [
            [['name', 'address', 'inn'], 'required', 'message' => 'Обязательное поле'],
            [['name', 'address'], 'string', 'max' => 128],
            [['inn'], 'integer', 'max' => 12],
            [['inn'], 'unique', 'targetClass' => 'common\models\Organization', 'message' => 'Данный ИНН уже зарегистрирован'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование организации',
            'address' => 'Адрес',
            'inn' => 'ИНН',
        ];
    }
}
