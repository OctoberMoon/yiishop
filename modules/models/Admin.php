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
            ['admin_name','required','message'=>'用户名不能为空','on'=>['login','seekpass']],
            ['admin_pass','required','message'=>'密码不能为空','on'=>'login'],
            ['remberMe','boolean','on'=>'login'],
            ['admin_pass','validataPass','on'=>'login'],
            [['login_time', 'login_ip', 'create_time'], 'integer'],
            [['admin_name', 'admin_pass'], 'string', 'max' => 32],
            [['admin_email'], 'email','message'=>'email格式不正确','on' => 'seekpass'],
            [['admin_email'], 'required','message'=>'email不能为空', 'on'=>'seekpass'],
            [['admin_email'], 'validataEmail', 'on'=>'seekpass'],
//            [['admin_name', 'admin_pass'], 'unique', 'targetAttribute' => ['admin_name', 'admin_pass'], 'message' => 'The combination of Username and Password has already been taken.'],
//            [['admin_name', 'admin_email'], 'unique', 'targetAttribute' => ['admin_name', 'admin_email'], 'message' => 'The combination of Username and Email has already been taken.'],
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
    public function validataEmail(){
        if (!$this->hasErrors()){
            $user=self::find()->where('admin_name = :user and admin_email = :admin_email',[":user"=>$this->admin_name,":admin_email"=>$this->admin_email])->one();
            if (is_null($user))
                $this->addError('admin_email','email错误！');
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
    public function seekpass($data){
        $this->scenario='seekpass';
        if ($this->load($data)&&$this->validate()){
            //邮箱验证成功
            //发送邮件
            $mailer=Yii::$app->mailer->compose('send');
            $mailer->setFrom('shop@163.com');
            $mailer->setTo($this->admin_email);
            $mailer->setSubject('SHOP-密码找回');
            $mailer->send();
            return $mailer->send();
        }
        return false;
    }
}