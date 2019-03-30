<?php
/**
 * Created by PhpStorm.
 * User: macmoming
 * Date: 2019/3/29
 * Time: 1:08 AM
 */
namespace app\modules\models;
use yii\db\ActiveRecord;
use yii;
class Admin extends ActiveRecord
{
    public $remberMe = true;
    public $repass;

    public static function tableName()
    {
        return '{{%admin}}';
    }


    /**
     * 数据验证
     */
    public function rules()
    {
        return [
            ['admin_name','required','message'=>'用户名不能为空','on' => ['login','seekpass', 'changepass', 'adminadd', 'changeemail']],
            ['admin_pass','required','message'=>'密码不能为空','on' => ['login', 'changepass', 'adminadd', 'changeemail   ']],
            ['remberMe','boolean','on'=>'login'],
            ['admin_pass','validataPass','on'=>['login','changeemail']],
            [['login_time', 'login_ip', 'create_time'], 'integer'],
            [['admin_name', 'admin_pass'], 'string', 'max' => 32],
            [['admin_email'], 'email','message'=>'email格式不正确','on' => ['seekpass', 'adminadd', 'changeemail']],
            [['admin_email'], 'required','message'=>'email不能为空',  'on' => ['seekpass', 'adminadd', 'changeemail']],
            [['admin_email'], 'validataEmail', 'on'=>'seekpass'],
            ['admin_email', 'unique', 'message' => '电子邮箱已被注册', 'on' => ['adminadd', 'changeemail']],
            ['admin_name', 'unique', 'message' => '管理员已被注册', 'on' => 'adminadd'],
            ['repass', 'compare', 'compareAttribute' => 'admin_pass', 'message' => '两次密码输入不一致', 'on' => ['changepass', 'adminadd']],
            ['repass', 'required', 'message' => '确认密码不能为空', 'on' => ['changepass', 'adminadd']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'adminid' => 'Adminid',
//            'admin_name' => 'Adminuser',
//            'admin_pass' => 'Admin_pass',
//            'admin_email' => 'Adminemail',
//            'logintime' => 'Logintime',
//            'loginip' => 'Loginip',
//            'createtime' => 'Createtime',

            'admin_name' => '管理员账号',
            'admin_pass' => '管理员密码',
            'admin_email' => '管理员邮箱',
            'repass' => '确认密码',

        ];
    }
    /**
     * 数据验证
     */
    public function validataPass(){
        if (!$this->hasErrors()){
            $user=self::find()->where('admin_name = :user and admin_pass = :pass',[":user"=>$this->admin_name,":pass"=>md5($this->admin_pass)])->one();
            if (is_null($user))
                $this->addError('admin_pass','用户名或密码错误');
        }
    }
    /**
     * 登录操作
     * @param $post
     * @return bool
     */
    public function login($post){
        $this->scenario = 'login';
        if ($this->load($post) && $this->validate()){//验证
            $rem=$this->remberMe ? 24*3600 :0 ;
            $session=Yii::$app->session;
            if(!isset($_SESSION)){
                session_set_cookie_params($rem);
                @session_regenerate_id(true);
                session_start();
            }
//            session_set_cookie_params($rem);
            $session['admin']=[
                'admin'=>$this->admin_name,
                'isLogin'=>1,
                'login_time'=>date('YmdHis')
            ];
            $this->updateAll(['login_time'=>time(),'login_ip'=>ip2long(Yii::$app->request->getUserIP())],"admin_name = :user",[':user' => $this->admin_name ]);
            return (boolean)$session['admin']['isLogin'];
        }
        return false;
    }
    public function seekPass($data)
    {
        $this->scenario = 'seekpass';
        if ($this->load($data) && $this->validate()) {
            $time = time();
            $token = $this->createToken($data['Admin']['admin_name'], $time);
            $mailer = Yii::$app->mailer->compose('send',['admin_name' => $data['Admin']['admin_name'], 'time' => $time, 'token' => $token]);
            $mailer->setFrom("shop@163.com");
            $mailer->setTo($data['Admin']['admin_email']);
            $mailer->setSubject("SHOP商城-找回密码");
            if ($mailer->send()) {
                return true;
            }

        }
        return false;
    }
    public function createToken($admin_name,$time)
    {
        return md5(md5($admin_name).base64_encode(Yii::$app->request->userIP).md5($time));
    }

    //修改密码

    public function changePass($data)
    {
        $this->scenario = 'changepass';
        if ($this->load($data) && $this->validate()) {
            return (bool)$this->updateAll(['admin_pass' => md5($this->admin_pass)], 'admin_name = :user', [':user' => $this->admin_name]);
        }
        return false;
    }
    //管理员注册

    public function reg($data)
    {
        $this->scenario = 'adminadd';
        if ($this->load($data) && $this->validate()) {  //save本身就包括 validate 方法
            $this->admin_pass = md5($this->admin_pass);
            $this->create_time = time();
            if ($this->save(false)) {
                return true;
            }
            return false;
        }
        return false;
    }
    //修改邮箱

    public function changeEmail($data)
    {
        $this->scenario = 'changeemail';
        if ($this->load($data) && $this->validate()) {
            return (bool)$this->updateAll(['admin_email' => $this->admin_email], 'admin_name = :user', [':user' => $this->admin_name]);
        }
        return false;
    }
    public function validataEmail(){
        if (!$this->hasErrors()){
            $user=self::find()->where('admin_name = :user and admin_email = :admin_email',[":user"=>$this->admin_name,":admin_email"=>$this->admin_email])->one();
            if (is_null($user))
                $this->addError('admin_email','email错误！');
        }
    }
}