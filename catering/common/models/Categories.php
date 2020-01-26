<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Categories extends ActiveRecord 
{
    
    public static function tableName()
    {
        return '{{%categories}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Обязательное поле'],
            [['name'], 'string', 'max' => 128],
            [['name'], 'unique', 'targetClass' => 'common\models\Categories', 'message' => 'Данная категория уже создана'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование категории',
        ];
    }

    public function getDishes($category_id)
    {
        return $this->hasMany(Dishes::classname(), [$category_id => 'id']);
    }
}
