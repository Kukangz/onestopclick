<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "voucher".
 *
 * @property int $id
 * @property int $type
 * @property string $code
 * @property int $counter
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $status
 * @property string $start_at
 * @property string $end_at
 * @property int $member_only
 */
class Voucher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'voucher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','type', 'code', 'counter', 'name','status','discount_type','discount_value'], 'required'],
            [['type', 'counter', 'created_by', 'updated_by', 'status', 'member_only'], 'integer'],
            [['created_at', 'updated_at', 'start_at', 'end_at','campaign_start','campaign_end'], 'safe'],
            [['code'], 'string', 'max' => 256],
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
            'type' => 'Type',
            'code' => 'Code',
            'campaign_start' => 'Campaign Start',
            'campaign_end' => 'Campaign End',
            'discount_type' => 'Discount Type',
            'discount_value' => 'Discount Value',
            'counter' => 'Counter',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'start_at' => 'Start At',
            'end_at' => 'End At',
            'member_only' => 'Member Only',
        ];
    }
}
