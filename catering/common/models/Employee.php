<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%employee}}".
 *
 * @property int $id
 * @property string $role
 * @property string $surname
 * @property string $name
 * @property string $fathername
 * @property string|null $login
 * @property int $pas_ser
 * @property int $pas_num
 * @property string $dob
 * @property string $e_date
 * @property string $by_whom
 * @property string $when
 * @property string $email
 * @property string $tel
 * @property string|null $status
 * @property string|null $pass
 */
class Employee extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUPER_ADMIN = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    public function rules()
    {
        return [
            [['role', 'surname', 'name', 'passport_series', 'passport_number', 'birth_date', 'date_of_employment',
                'passport_issued_by', 'date_of_issue_of_passport', 'email', 'telephone', 'pass', 'login'], 'required', 'message' => 'Обязательное поле'],
            [['passport_series', 'passport_number'], 'integer'],
            [['surname', 'name', 'passport_series', 'passport_number', 'birth_date', 'date_of_employment', 'passport_issued_by',
                'date_of_issue_of_passport', 'email'], 'trim'],
            [['role', 'login'], 'string', 'max' => 16],
            [['surname', 'name', 'fathername'], 'string', 'max' => 64],
            [['birth_date', 'date_of_employment', 'date_of_issue_of_passport'], 'date', 'format' => 'dd.mm.yyyy', 'message' => 'Неверный формат даты (дд.мм.гггг)'],
            [['passport_issued_by', 'email'], 'string', 'max' => 128],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['pass'], 'string', 'min' => 8],
            [['login'],
                'unique',
                'when' => function ($model)
                {
                    return $model->login !== Yii::$app->getRequest()->getBodyParam('login')
                        || (!empty($model->login));
                },
                'message' => 'Данный логин уже зарегистрирован',
            ],
            [['email'],
                'unique',
                'when' => function ($model)
                {
                    return $model->email !== Yii::$app->getRequest()->getBodyParam('email')
                        || (!empty($model->email));
                },
                'message' => 'Данный e-mail уже зарегистрирован',
            ],
            [['telephone'],
                'unique',
                'when' => function ($model)
                {
                    return $model->telephone !== Yii::$app->getRequest()->getBodyParam('telephone')
                        || (!empty($model->telephone));
                },
                'message' => 'Данный телефон уже зарегистрирован',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'role' => 'Роль',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'fathername' => 'Отчество (если имеется)',
            'login' => 'Придумайте логин',
            'passport_series' => 'Серия паспорта',
            'passport_number' => 'Номер паспорта',
            'birth_date' => 'Дата рождения',
            'date_of_employment' => 'Дата приема на работу',
            'passport_issued_by' => 'Кем выдан',
            'date_of_issue_of_passport' => 'Когда выдан',
            'email' => 'E-mail',
            'telephone' => 'Телефон',
            'pass' => 'Придумайте пароль',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $director = $auth->getRole('director');
        $manager = $auth->getRole('manager');
        $auth->revokeAll($this->id);
        if ($this->role == 'Администратор') {
            $auth->assign($admin, $this->id); 
        } elseif ($this->role == 'Директор') {
            $auth->assign($director, $this->id); 
        } elseif ($this->role == 'Менеджер') {
            $auth->assign($manager, $this->id); 
        }
        $this->pass = Yii::$app->security->generatePasswordHash($this->pass);
    }

    public function search($searching, $status)
    {
        return self::find()
            ->where(['like', 'surname', $searching])
            ->orWhere(['like', 'name', $searching])
            ->orWhere(['like', 'fathername', $searching])
            ->andWhere(['status' => $status])
            ->all();
    }

    public function sorting($field, $type, $status)
    {
        return self::find()
            ->where(['status' => $status])
            ->orderBy([$field => $type])
            ->all();
    }

    public function change_status($id, $status)
    {
        Yii::$app->db->createCommand()
            ->update('employee', ['status' => $status], 'id = :id', [':id' => $id])
            ->execute();
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    public function getAuthKey()
    {

    }

    public function validateAuthKey($authKey)
    {

    }

    public static function findByUsername($login)
    {
      return self::find()
          ->where(['login' => $login, 'status' => self::STATUS_ACTIVE])
          ->orWhere(['login' => $login, 'status' => self::STATUS_SUPER_ADMIN])
          ->one();
    }

    public function validatePassword($pass)
    {
      return Yii::$app->security->validatePassword($pass, $this->pass);
    }
}
