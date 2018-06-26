<?php

namespace backend\models\activerecord;

use Yii;

/**
 * This is the model class for table "backend_feature".
 *
 * @property int $id
 * @property int $feature_group
 * @property string $name
 * @property string $icon
 * @property string $slug
 * @property int $status
 *
 * @property FeatureGroup $featureGroup
 * @property BackendPermission[] $backendPermissions
 */
class Feature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backend_feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['feature_group', 'name', 'icon', 'slug', 'status'], 'required'],
            [['feature_group', 'status'], 'integer'],
            [['name', 'icon', 'slug'], 'string', 'max' => 32],
            [['feature_group'], 'exist', 'skipOnError' => true, 'targetClass' => FeatureGroup::className(), 'targetAttribute' => ['feature_group' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'feature_group' => 'Feature Group',
            'name' => 'Name',
            'icon' => 'Icon',
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatureGroup()
    {
        return $this->hasOne(FeatureGroup::className(), ['id' => 'feature_group']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackendPermissions()
    {
        return $this->hasMany(BackendPermission::className(), ['feature' => 'id']);
    }
}
