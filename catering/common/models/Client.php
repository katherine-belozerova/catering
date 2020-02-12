<?php


namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\Organization;
use yii\helpers\ArrayHelper;

class Client extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%client}}';
    }

    public function rules()
    {
        return [
            [['name', 'surname', 'type', 'birth_date', 'telephone', 'email', 'organization_id'], 'required', 'message' => 'Обязательное поле'],
            [['name', 'surname', 'fathername', 'telephone'], 'string', 'max' => 128],
            [['type'], 'string', 'max' => 12],
            [['birth_date'], 'date', 'format' => 'd.m.yy'],

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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->date_added = date('d.m.yy');
            }
            return true;
        }
    }

    public function list_of_clients($field, $type)
    {
        $data = Client::find()->asArray()->all();
        $data = array_map(function($value) {
            $value['organization'] = Organization::find()
                ->select('name')
                ->where(['organization_id' => $value['organization_id']])
                ->one();
            return $value;
        }, $data);
        ArrayHelper::multisort($data, $field, $type);
        return $data;
    }

    public function search($searching)
    {
        return self::find()
            ->where(['like', 'surname', $searching])
            ->orWhere(['like', 'name', $searching])
            ->orWhere(['like', 'fathername', $searching])
            ->all();
    }
}
