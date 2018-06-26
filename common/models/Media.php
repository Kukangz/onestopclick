<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property int $name
 * @property int $media_type
 * @property string $image
 * @property string $image_portrait
 * @property string $image_secondary
 * @property string $image_thumbnail
 * @property string $video_url
 * @property int $is_embed
 * @property string $create_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'media_type', 'image', 'video_url'], 'required'],
            [['media_type', 'is_embed', 'created_by', 'updated_by'], 'integer'],
            [['create_at', 'updated_at','updated_by', 'created_by','is_embed','embed_tag','external_url'], 'safe'],
            [['image', 'image_portrait', 'image_secondary', 'image_thumbnail', 'video_url'], 'string', 'max' => 128],
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
            'media_type' => 'Media Type',
            'image' => 'Image',
            'image_portrait' => 'Image Portrait',
            'image_secondary' => 'Image Secondary',
            'image_thumbnail' => 'Image Thumbnail',
            'video_url' => 'Video Url',
            'is_embed' => 'Is Embed',
            'create_at' => 'Create At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
