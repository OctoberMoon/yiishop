<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\users;

class IndexController extends Controller
{
    public $layout=false;

    public function actionIndex(){
        $this->layout="home";
        return $this->render("index");
    }
}



