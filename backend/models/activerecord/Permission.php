<?php

namespace backend\models\activerecord;

use Yii;

/**
 * This is the model class for table "backend_permission".
 *
 * @property int $id
 * @property int $roles
 * @property int $feature
 *
 * @property BackendFeature $feature0
 * @property BackendUserRoles $roles0
 */
class Permission extends \yii\db\ActiveRecord
{

    public $feature_name;
    public $feature_slug;

    const FULL_ACCESS = 2;
    const READONLY = 1;
    const NO_ACCESS = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backend_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['roles', 'feature'], 'required'],
            [['roles', 'feature'], 'integer'],
            [['feature'], 'exist', 'skipOnError' => true, 'targetClass' => Feature::className(), 'targetAttribute' => ['feature' => 'id']],
            [['roles'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['roles' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'roles' => 'Roles',
            'feature' => 'Feature',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeature0()
    {
        return $this->hasOne(Feature::className(), ['id' => 'feature']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles0()
    {
        return $this->hasOne(Roles::className(), ['id' => 'roles']);
    }
}
