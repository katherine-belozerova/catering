<?php

namespace common\models;

use yii\db\ActiveRecord;
use Yii;


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
            [['inn'], 'string', 'max' => 12],
            [['inn'],
                'unique',
                'when' => function ($model)
                {
                    return $model->inn !== Yii::$app->getRequest()->getBodyParam('inn')
                        || (!empty($model->inn));
                },
                'message' => 'Организация с таким ИНН уже зарегистрирована',
            ],
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

    public function sorting($field, $type)
    {
        return Organization::find()
            ->orderBy([$field => $type])
            ->all();
    }

    public function search($searching)
    {
        return self::find()
            ->where(['like', 'name', $searching])
            ->all();
    }
}
