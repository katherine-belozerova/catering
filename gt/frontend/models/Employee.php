<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\web\Linkable;

class Employee extends \common\models\Employee implements Linkable
{
	public function fields(){
		return parent::fields();
	}

	public function getLinks()
	{
		return [
			'create' => Url::to(['employee/create', 'id' => $this->id], true),
		];
	}
}
