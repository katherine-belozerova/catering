<?php

namespace frontend\models;

use Yii;
use common\models\Employee;
use yii\helpers\Url;
use yii\web\Linkable;

class Empl extends Employee
{
	public function fields()
	{
		return parent::fields();
	}

}