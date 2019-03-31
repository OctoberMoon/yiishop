<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<!-- ========================================= MAIN ========================================= -->
<main id="authentication" class="inner-bottom-md">
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <section class="section sign-in inner-right-xs">
                    <h2 class="bordered">
                        <img src="<?php echo Yii::$app->session['userinfo']['figureurl_1']?>" alt="图片加载失败">
                        完善信息
                    </h2>
                    <p>请您填写一个您的账户名和密码</p>
                    <?php
                    $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'login-form cf-style-1',
                            'role' => 'form',
                        ],
                        'fieldConfig' => [
                            'template' => '<div class="field-row">{label}{input}</div>{error}'
                        ],
                    ])
                    ?>
                    <input type="text" value="<?php echo Yii::$app->session['userinfo']['nickname']?Yii::$app->session['userinfo']['nickname']:'未知昵称'?>" readonly class="le-input"><br/>
                    <?php echo $form->field($model, 'user_name')->textInput(['class' => 'le-input']); ?>
                    <?php echo $form->field($model, 'user_pass')->passwordInput(['class' => 'le-input']); ?>
                    <?php echo $form->field($model, 'repass')->passwordInput(['class' => 'le-input']); ?>
                    <div class="buttons-holder">
                        <?php echo Html::submitButton('完善信息', ['class' => 'le-button huge']); ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </section>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
</main><!-- /.authentication -->
