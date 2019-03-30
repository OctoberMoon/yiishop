<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加新用户</h3></div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php if (Yii::$app->session->hasFlash('info')) {
                            echo Yii::$app->session->getFlash('info');
                        } ?>
                        <?php $form = ActiveForm::begin([
                            'options' => ['class' => 'new_user_form inline-input'],
                            'fieldConfig' => [
                                'template' => '<div class="span12 field-box">{label}{input}{error}</div>'
                            ],
                        ]) ?>
                        <?= $form->field($model,'user_name')->textInput(['class' => 'span9']) ?>
                        <?= $form->field($model,'user_pass')->passwordInput(['class' => 'span9']) ?>
                        <?= $form->field($model,'repass')->passwordInput(['class' => 'span9']) ?>
                        <?= $form->field($model,'user_email')->textInput(['class' => 'span9']) ?>

                        <div class="span11 field-box actions">
                            <?= Html::submitButton('创建', ['class' => 'btn-glow primary'])?>
                            <span>或者</span>
                            <?= Html::resetButton('取消', ['class' => 'reset'])?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧填写管理员相关信息，包括管理员账号，电子邮箱，以及密码</div>
                    <h6>商城用户说明</h6>
                    <p>可以在前台进行登录并且进行购物</p>
                    <p>前台也可以注册用户</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- end main container -->