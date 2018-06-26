<?php

namespace frontend\models\form;

use frontend\models\activerecord\User;
use Yii;
use yii\base\Model;
/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $picture
 * @property int $social_media_type
 * @property string $social_media_id
 
 * @property string $password
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $status
 */
class RegisterForm extends Model
{

    public $_user;
    public $name;
    public $address;
    public $email;
    public $picture;
    public $social_media_type;
    public $social_media_id;
    public $repeat_password;
    public $password;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','address','email','password'], 'required'],
            ['password', 'filterpassword'],
            ['email', 'filteremail'],
            [['name', 'email', 'social_media_id'], 'string', 'max' => 64],
            [['address', 'picture'], 'string', 'max' => 128],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
            [['password'], 'string', 'max' => 256],
            [['repeat_password'], 'required'],
            [['repeat_password'], 'safe'],
            ['status', 'default', 'value' => User::STATUS_ACTIVE],
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
            'address' => 'Address',
            'email' => 'Email',
            'picture' => 'Picture',
            'social_media_type' => 'Social Media Type',
            'social_media_id' => 'Social Media ID',
            'password' => 'Password',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }



    /**
     * [filterpassword description]
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     * @return [type]            [description]
     */
    public function filterpassword($attribute, $params)
    {

    }

        /**
     * [filterpassword description]
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     * @return [type]            [description]
     */
        public function filteremail($attribute, $params)
        {
            if (!$this->hasErrors()) {
                $user = $this->getUser();
                if ($user) {
                    $this->addError($attribute, 'Email already used, please use another email');
                }
            }
        }

        public function save(){
            if ($this->validate()) {
                $model = new User();
                $model->name = $this->name;
                $model->address = $this->address;
                $model->email = $this->email;
                $model->password = md5($this->password);
                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');
                $model->status = 1;
                $model->save();
                return true;
            }
            return false;
        }

    /**
     * Finds user by [[email]]
     *
     * @return Email|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }

    private function __sendmail($email, $user, $code){
        return Yii::$app->mailer->compose('reset-password', ['name' => $user, 'code' => $code])
        ->setTo($email)
        ->setFrom('no-reply@onestopclicking.com')
        ->setSubject('Reset password Link')
        ->send();
    }
}
