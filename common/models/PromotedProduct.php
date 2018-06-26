<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promoted_product".
 *
 * @property int $id
 * @property int $product
 * @property string $start_date
 * @property string $end_date
 * @property string $synopsis
 * @property string $description
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $status
 */
class PromotedProduct extends \yii\db\ActiveRecord
{

    public $name;
    public $picture_thumbnail;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promoted_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['end_date', 'synopsis', 'description'], 'required'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['synopsis'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'synopsis' => 'Synopsis',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        // hash password on before saving the record:
        
        $this->updated_at = date('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }
}
