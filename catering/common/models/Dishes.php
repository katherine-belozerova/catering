<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Dishes extends ActiveRecord 
{
    
    public static function tableName()
    {
        return '{{%dishes}}';
    }

    public function rules()
    {
        return [
            [['name', 'weight', 'cost', 'category_id'], 'required', 'message' => 'Обязательное поле'],
            [['name', 'notes'], 'string', 'max' => 128],
            [['name'],
                'unique',
                'when' => function ($model)
                {
                    return $model->name !== Yii::$app->getRequest()->getBodyParam('name')
                        || (!empty($model->name));
                },
                'message' => 'Данное блюдо уже создано',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование блюда',
            'weight' => 'Вес порции',
            'cost' => 'Цена порции',
            'notes' => 'Примечания',
        ];
    }
}
