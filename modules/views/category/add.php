<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
?>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加新分类</h3></div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php
                            if (Yii::$app->session->hasFlash('info')) {
                                echo Yii::$app->session->getFlash('info');
                            }
                            $form = ActiveForm::begin([
                               'fieldConfig' => [
                                   'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
                               ],
                               'options' => [
                                   'class' => 'new_user_form inline-input',
                               ]
                            ]);
                        ?>
                            <?= $form->field($model, 'parent_id')->dropDownList($list) ?>
                            <?= $form->field($model, 'title')->textInput(['class' => 'span9']) ?>
<!--                            <div class="form-group field-category-parent_id required">-->
<!--                                <div class="span12 field-box">-->
<!--                                    <label class="control-label" for="category-parent_id">上级分类</label>-->
<!--                                    <select id="category-parent_id" class="form-control" name="Category[parent_id]">-->
<!--                                        <option value="0">添加顶级分类</option>-->
<!--                                        <option value="1">|-----服装</option>-->
<!--                                        <option value="2">|-----|-----上衣</option>-->
<!--                                        <option value="3">|-----电子产品</option>-->
<!--                                        <option value="6">|-----|-----手机</option>-->
<!--                                        <option value="4">|-----充气娃娃</option>-->
<!--                                        <option value="5">|-----|-----仓也空井也空</option></select>-->
<!--                                </div>-->
<!--                                <p class="help-block help-block-error"></p>-->
<!--                            </div>-->
<!--                            <div class="form-group field-category-title required">-->
<!--                                <div class="span12 field-box">-->
<!--                                    <label class="control-label" for="category-title">分类名称</label>-->
<!--                                    <input type="text" id="category-title" class="span9" name="Category[title]">-->
<!--                                </div>-->
<!--                                <p class="help-block help-block-error"></p>-->
<!--                            </div>-->
                            <div class="span11 field-box actions">
                                <?= Html::submitButton('添加', ['class' => 'btn-glow primary']) ?>
<!--                                <button type="submit" class="btn-glow primary">添加</button>-->
                                <span>OR</span>
                                <?= Html::resetButton('取消', ['class' => 'reset']) ?>
<!--                                <button type="reset" class="reset">取消</button>-->
                            </div>
<!--                        </form>-->
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧表单当中填写要添加的分类，请选择好上级分类</div>
                    <h6>商城分类说明</h6>
                    <p>该分类为无限级分类</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->