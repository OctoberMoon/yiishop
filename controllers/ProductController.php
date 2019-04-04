<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Product;
class ProductController extends Controller
{
    public $layout = 'layout_auth';
    public function actionIndex(){
        $products = [];
        return $this->render("index",compact('products'));
    }

    public function actionDetail()
    {
        return $this->render("detail");
    }
}



