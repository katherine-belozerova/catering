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

    public function getCategories()
    {
        return $this->hasOne(Categories::classname(), ['id' => 'category_id']);
    }
}
