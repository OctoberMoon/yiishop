<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\users;
class IndexController extends Controller
{
    public function actionIndex(){
//        echo 123;
        $users = new users;
        $data = $users->find()->one();
        return $this->render("index",compact('data'));
    }
}



