<?php

namespace frontend\models;

use Yii;
use common\models\Categories;
use yii\helpers\Url;

class Category extends Categories
{
	public function fields()
	{
		return parent::fields();
	}

	public function extraFields()
	{
    	return ['dish'];
	}

}