<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html class="login-bg">

<head>
    <title>SHOP商城 - 后台管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- bootstrap -->
    <link href="assets/admin/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/admin/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="assets/admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="assets/admin/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="assets/admin/css/elements.css" />
    <link rel="stylesheet" type="text/css" href="assets/admin/css/icons.css" />
    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="assets/admin/css/lib/font-awesome.css" />
    <!-- this page specific styles -->
    <link rel="stylesheet" href="assets/admin/css/compiled/signin.css" type="text/css" media="screen" />
    <!-- open sans font -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
<div class="row-fluid login-wrapper">
    <a class="brand" href="index.html"></a>
    <?php $form = ActiveForm::begin() ?>

    <div class="span4 box">
        <div class="content-wrap">
            <h6>SHOP商城 - 后台管理</h6>
            <div class="form-group field-admin-adminuser">
                <p class="help-block help-block-error"></p>
                <?=$form->field($model,'admin_name')->textInput(['class'=>'span12', 'id'=>'admin-username','placeholder'=>'管理员账号'])->label(false) ?>
                <div class="form-group field-admin-adminpass">
                    <p class="help-block help-block-error"></p>
                    <?=$form->field($model,'admin_pass')->textInput(['class'=>'span12', 'id'=>'admin-password','placeholder'=>'管理员密码'])->label(false)?>
                </div>

                <a href="<?=\yii\helpers\Url::toRoute('public/seekpassword')?>" class="forgot">忘记密码?</a>
                <div class="form-group field-remember-me">
                    <?= $form->field($model,'rememberMe')->checkbox([
                        'id'=>"remember-me",
                        'template'=>'<div class="remember">{input}{label}</div>'
                    ])->label('记住我') ?>
                    <?=Html::submitButton('登录',['class'=>"btn-glow primary login"])?>
                </div>
                <?php ActiveForm::end() ?>
</div>
<!-- scripts -->
<script src="assets/admin/js/jquery-latest.js"></script>
<script src="assets/admin/js/bootstrap.min.js"></script>
<script src="assets/admin/js/theme.js"></script>
<!-- pre load bg imgs -->
<script type="text/javascript">$(function() {
        // bg switcher
        var $btns = $(".bg-switch .bg");
        $btns.click(function(e) {
            e.preventDefault();
            $btns.removeClass("active");
            $(this).addClass("active");
            var bg = $(this).data("img");

            $("html").css("background-image", "url('img/bgs/" + bg + "')");
        });

    });</script>
</body>

</html>