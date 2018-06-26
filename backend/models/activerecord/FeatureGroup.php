<?php

namespace backend\models\activerecord;

use Yii;

/**
 * This is the model class for table "backend_feature_group".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property string $icon
 *
 * @property BackendFeature[] $backendFeatures
 */
class FeatureGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backend_feature_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'status', 'icon'], 'required'],
            [['status'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 32],
            [['icon'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'status' => 'Status',
            'icon' => 'Icon',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackendFeatures()
    {
        return $this->hasMany(BackendFeature::className(), ['feature_group' => 'id']);
    }
}
