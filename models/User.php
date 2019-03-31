<?php

namespace app\models;

use Yii;
use app\models\Profile;

/**
 * This is the model class for table "shop_user".
 *
 * @property string $user_id
 * @property string $user_name
 * @property string $user_pass
 * @property string $user_email
 * @property string $create_time
 */
class User extends \yii\db\ActiveRecord
{
    public $repass;
    public $login_name;
    public $rememberMe = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['login_name', 'required', 'message' => '登录用户名不能为空', 'on' => ['login']],
            ['open_id', 'required', 'message' => 'openid不能为空', 'on' => ['qqreg']],
            ['user_name', 'required', 'message' => '用户名不能为空', 'on' => ['reg', 'regbymail', 'qqreg']],
            ['open_id', 'unique', 'message' => 'openid已经被注册', 'on' => ['qqreg']],
            ['user_name', 'unique', 'message' => '用户已经被注册', 'on' => ['reg', 'regbymail', 'qqreg']],
            ['user_email', 'required', 'message' => '电子邮件不能为空', 'on' => ['reg', 'regbymail']],
            ['user_email', 'email', 'message' => '电子邮件格式不正确', 'on' => ['reg', 'regbymail']],
            ['user_email', 'unique', 'message' => '电子邮件已被注册', 'on' => ['reg', 'regbymail']],
            ['user_pass', 'required', 'message' => '用户密码不能为空', 'on' => ['reg', 'login', 'regbymail', 'qqreg']],
            ['repass', 'required', 'message' => '确认密码不能为空', 'on' => ['reg', 'qqreg']],
            ['repass', 'compare', 'compareAttribute' => 'user_pass', 'message' => '两次密码输入不一致', 'on' => ['reg', 'qqreg']],
            ['user_pass', 'validatePass', 'on' => ['login']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_name' => '用户名',
            'user_pass' => '用户密码',
            'repass' => '确认密码',
            'user_email' => '电子邮箱',
            'login_name' => '用户名/电子邮箱',
        ];
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
    }

    public function reg($data,$scenario='reg')
    {
        $this->scenario = $scenario;
        if ($this->load($data) && $this->validate()) {
            $this->create_time = time();
            $this->user_pass = md5($this->user_pass);
            if ($this->save(false)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function regByMail($data)
    {
        $this->scenario = 'regbymail';
        $data['User']['user_name'] = 'shop_'.uniqid();
        $data['User']['user_pass'] = uniqid();
        if ($this->load($data) && $this->validate()) {
            $mailer = Yii::$app->mailer->compose('create_user',['user_name'=>$data['User']['user_name'],'user_pass'=>$data['User']['user_pass']]);
            $mailer->setFrom('shop@163.com');
            $mailer->setTo($data['User']['user_email']);
            $mailer->setSubject('SHOP商城-创建用户');
            if ($mailer->send() && $this->reg($data,'regbymail')) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function login($data)
    {
        $this->scenario = "login";
        if ($this->load($data) && $this->validate()) {
            $lifetime = $this->rememberMe ? 24*3600 : 0;
            $session = Yii::$app->session;
            if(!isset($_SESSION)){
                session_set_cookie_params($lifetime);
                @session_regenerate_id(true);
                session_start();
            }
//            session_set_cookie_params($lifetime);
            $session['login_name'] = $this->login_name;
            $session['isLogin'] = 1;
            return (bool)$session['isLogin'];
        }
        return false;
    }

    public function validatePass()
    {
        if (!$this->hasErrors()) {
            $login_name = "user_name";
            if (preg_match('/@/', $this->login_name)) {
                $login_name = "user_email";
            }
            $data = self::find()->where($login_name.' = :login_name and user_pass = :pass', [':login_name' => $this->login_name, ':pass' => md5($this->user_pass)])->one();
            if (is_null($data)) {
                $this->addError("user_pass", "用户名或者密码错误");
            }
        }
    }
}
