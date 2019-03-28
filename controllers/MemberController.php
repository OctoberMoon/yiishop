<?php
namespace app\controllers;

use yii\web\Controller;

class MemberController extends Controller
{
    public $layout = false;
    public function actionAuth()
    {
        $this->layout="layout_auth";

        return $this->render("auth");
    }
}