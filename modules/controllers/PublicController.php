<?php

namespace app\modules\controllers;
use Yii;
use app\modules\models\Admin;
class PublicController extends \yii\web\Controller
{
    public $layout=false;
    public function actionLogin()
    {
        $model=new Admin();
//        if (Yii::$app->session['admin']['isLogin']) {
//            $this->redirect(['default/index']);
//            Yii::$app->end();
//        }
//        if (Yii::$app->request->isPost){
//            if($model->login(Yii::$app->request->post()))
//                $this->redirect(['default/index']);
//            Yii::$app->end();
//
//        }
        return $this->render('login',['model'=>$model]);
    }
    public function actionLogout(){
        Yii::$app->session->remove('admin');
        if(!Yii::$app->session['admin']['isLogin']){
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        $this->goBack();
    }
    public function actionSeekpassword(){
        $model=new Admin();
        if (Yii::$app->request->isPost){
            if($model->seekpass(Yii::$app->request->post())){
                Yii::$app->session->setFlash('info',"发送成功，请查收！！！");
//                $this->redirect(['public/login']);
            }

        }
        return $this->render('seekpassword',['model'=>$model]);
    }

}
