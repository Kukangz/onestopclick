<?php

namespace common\models;

use yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use \godzie44\yii\behaviors\image\ImageBehavior;
use yii\imagine\Image;
use common\models\face\CartItemInterface;


/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $PID
 * @property string $name
 * @property string $description
 * @property int $category
 * @property string $price
 * @property int $brand
 * @property int $status
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Product extends ActiveRecord implements CartItemInterface
{

  const STATUS_ACTIVE = 1;
  const STATUS_INACTIVE = 0;
  public $category_name;
  public $category_slug;
  public $sub_category_name;
  public $sub_category_slug;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
      return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
      return [
        [['PID', 'name', 'description','slug'], 'required'],
        [['category', 'brand', 'status', 'created_by', 'updated_by'], 'integer'],
        [['price'], 'number'],
        [['created_at', 'updated_at','embed_video','embed_music_player','official_site','meta_description','meta_keywords','product_download_link','picture_headline'], 'safe'],
        [['PID', 'description'], 'string', 'max' => 255],
        [['name'], 'string', 'max' => 64],
        [['PID'], 'unique'],
        [['picture'], 'file', 'extensions' => 'png, jpg, jpeg'],
      ];
    }

    public function behaviors()
    {
      return [
        [
          'class' => ImageBehavior::className(),
          'imageAttr' => 'picture',
          'images' => [
                  '_default' => ['default' => []], //save default upload image
                  '_small' => ['resize' => [500,500]], //and save resized copy
                ]
              ]
            ]
            ;
          }


 //getter of resized image
          public function getSmallAvatar(){
            return $this->getImage('_small');
          }

/**
 * [upload description]
 * @param  [type]  $path     [description]
 * @param  boolean $filename [description]
 * @return [type]            [description]
 */
public function upload($path, $filename = false)
{
  if ($this->validate()) {
    if(!$this->picture){
      return false;
    }
    FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

    if(!$filename){
      $filename = $this->picture->BaseName;
    }

    $originFile = $path . $filename . '.' . $this->picture->extension;
    $this->picture->saveAs($originFile);
    $thumbnFile = $path . $filename . '-thumb.' .  $this->picture->extension;
    $portrait = $path . $filename . '-portrait.' .  $this->picture->extension;
    $headline = $path . $filename . '-headline.' .  $this->picture->extension;

    Image::resize($originFile, 250, 250, false, true)->save($thumbnFile, ['quality' => 80]);
    Image::resize($originFile, 500, 250, false, true)->save($portrait, ['quality' => 80]);
    Image::resize($originFile, 750, 750, false, true)->save($headline, ['quality' => 100]);
            // $this->save();
    return ['filename' => $filename,'extension' => '.'.$this->picture->extension];
  } else {
    return false;
  }
}


public function product_upload($path, $filename = false){
  if(!$this->product_download_link){
      return false;
    }
  FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

  if(!$filename){
    $filename = $this->product_download_link->BaseName;
  }

  $originFile = $path . $filename . '.' . $this->product_download_link->extension;
  $this->product_download_link->saveAs($originFile);

  
  return ['filename' => $filename,'extension' => '.'.$this->product_download_link->extension];
}



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
      return [
        'id' => 'ID',
        'PID' => 'Pid',
        'name' => 'Name',
        'description' => 'Description',
        'category' => 'Category',
        'price' => 'Price',
        'brand' => 'Brand',
        'status' => 'Status',
        'created_at' => 'Created At',
        'created_by' => 'Created By',
        'updated_at' => 'Updated At',
        'updated_by' => 'Updated By',
      ];
    }


    /**
 * @inheritdoc
 */
    public function beforeSave($insert)
    {
      if ($insert) {
        // This is a new instance of modelClass, run your 'insert' code here.
        $this->created_at = date('Y-m-d H:i:s');
        $this->created_by = Yii::$app->user->identity->id;
      }
        // Anything else will be run any time a model is saved.
      if($this->updated_at)
        $this->updated_at = date('Y-m-d H:i:s');
      return parent::beforeSave($insert);
    }


    public function getCategory()
    {
      return $this->hasOne(Category::className(), ['category' => 'id'])->select('name')->scalar();
    }

        /**
     * Returns the price for the cart item
     *
     * @return int
     */
        public function getPrice(){
          return $this->price;
        }
    /**
     * Returns the label for the cart item (displayed in cart etc)
     *
     * @return int|string
     */
    public function getLabel(){
      return $this->name;
    }
    /**
     * Returns unique id to associate cart item with product
     *
     * @return int|string
     */
    public function getUniqueId(){
      return $this->id;
    }
  }
