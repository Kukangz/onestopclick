<?php
namespace backend\models\form;

use Yii;
use yii\base\Model;
use backend\models\activerecord\BackendUser;
use backend\models\activerecord\Permission;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($user->password,$this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {

            $permission = Permission::find()->joinWith('feature0',false,'inner join')->leftjoin('backend_feature_group','`backend_feature`.`feature_group` = `backend_feature_group`.`id`')->where(['roles' => $this->_user->roles,'backend_feature_group.status' => 1,'backend_feature.status' => 1])->select(['backend_feature_group.name as feature_group','backend_feature_group.icon as feature_group_icon','backend_feature_group.slug as feature_group_slug','backend_feature'.'.name','backend_feature'.'.slug', 'backend_feature'.'.icon','backend_permission'.'.access'])->orderBy('backend_feature_group.name', SORT_ASC)->asArray()->all();
            $menu = $group = $list = [];
            foreach($permission as $item){
                if(!isset($group[strtolower($item['feature_group'])])){
                    $group[strtolower($item['feature_group'])] = ['name' => $item['feature_group'],'icon' => $item['feature_group_icon'],'slug' => $item['feature_group_slug']];
                }
                $menu[strtolower($item['feature_group'])][] = ['name' => $item['name'], 'slug' => $item['slug'],'icon' => $item['icon'],'access' => $item['access']];
                $list[$item['slug']] = ['name' => $item['name'], 'slug' => $item['slug'],'icon' => $item['icon'],'access' => $item['access']];
            }

            $result = ['group' => $group,'menu' => $menu, 'list' => $list];
            $session = Yii::$app->session;
            $session->set('menu', $result);
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = BackendUser::findByEmail($this->email);
        }

        return $this->_user;
    }
}
