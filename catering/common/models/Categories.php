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

    public function list_of_categories()
    {
        $data = Categories::find()->asArray()->all();
        $data = array_map(function($value) {
            $value['number'] = Dishes::find()
                ->where(['category_id' => $value['category_id']])
                ->count();
            return $value;
        }, $data);
        return $data;
    }

    public function delete_all($id)
    {
        Dishes::deleteAll('category_id = :id', [':id' => $id]);
        Categories::deleteAll('category_id = :id', [':id' => $id]);
    }
}
