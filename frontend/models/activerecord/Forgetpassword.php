<?php 

namespace frontend\models\activerecord;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Forgetpassword extends ActiveRecord{
	const STATUS_USED = -9;
	const STATUS_AVAILABLE = 1;
	const STATUS_EXPIRED = 0;

	public static function tableName()
	{
		return '{{%forget_password}}';
	}
}