<?php
namespace app\controllers;

use yii\web\Controller;
class ProductController extends Controller
{
    public $layout=false;
    public function actionIndex(){
        $this->layout="layout_auth";
        return $this->render("index");
    }

    public function actionDetail()
    {
        $this->layout="layout_auth";
        return $this->render("detail");
    }
}



