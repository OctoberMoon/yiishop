<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\User;
use yii;
class MemberController extends Controller
{
    public $layout = false;

    /**
     * 前台登陆操作
     */
    public function actionAuth()
    {
        $this->layout="layout_auth";
        $model = new User();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->login($post)) {
                return $this->redirect(['index/index']);
            }
        }
        return $this->render('auth', [
            'model' => $model,
        ]);
    }

    /**
     * 登出操作
     */
    public function actionLogout()
    {
        Yii::$app->session->remove('login_name');
        Yii::$app->session->remove('isLogin');
        if (!isset(Yii::$app->session['isLogin'])) {
            return $this->goBack(Yii::$app->request->referrer);
        }

    }

    /**
     * 邮箱注册
     * @return string
     */
    public function actionReg()
    {
        $model = new User();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->regByMail($post)) {
                Yii::$app->session->setFlash('info', '电子邮件发送成功!');
            }
        }
        $this->layout = 'layout_auth';
        return $this->render('auth', [
            'model' => $model,
        ]);
    }

    /**
     * QQ登陆页面
     */
    public function actionLogin_qq()
    {
        require_once('../vendor/qqlogin/qqConnectAPI.php');
        $qc = new \QC();
        $qc->qq_login();
    }

    /**
     * QQ登陆操作
     */
    public function actionQq_callback()
    {
        require_once('../vendor/qqlogin/qqConnectAPI.php');
        $auth = new \OAuth();
        $accessToken = $auth->qq_callback();
        $openID = $auth->get_openId();
        $qc = new \QC($accessToken,$openID);
        $userInfo = $qc->get_user_info();
        $session = Yii::$app->session;
        $session['userinfo'] =$userInfo;
        $session['openid'] =$openID;
        if (User::find()->where(['open_id = :open_id',[':open_id'=>$openID]])->one()) {
            $session['login_name'] = $userInfo['nick_name'];
            $session['isLogin'] = 1;
            return $this->redirect('index/index');
        }
        return $this->redirect('member/qq_reg');
    }

    /**
     * QQ 注册
     */
    public function actionQq_reg()
    {
        $this->layout = 'layout_auth';
        $model = new User;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
//            $post['User']['open_id'] = Yii::$app->session['openid'];
            //临时验证
            $post['User']['open_id'] = uniqid();
            if ($model->reg($post,'qqreg')) {
                $lifetime = 24*3600;
                $session = Yii::$app->session;
                if(!isset($_SESSION)){
                    session_set_cookie_params($lifetime);
                    @session_regenerate_id(true);
                    session_start();
                }
//            session_set_cookie_params($lifetime);
                $session['login_name'] = $post['User']['user_name'];
                $session['isLogin'] = 1;
                return $this->redirect(['index/index']);
            }
        }
        return $this->render('qq_reg',compact('model'));
    }
}
