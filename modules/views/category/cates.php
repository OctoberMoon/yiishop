<?php
    use yii\helpers\Url;
?>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>分类列表</h3>
                <div class="span10 pull-right">
                    <a href="<?= Url::to(['category/add']) ?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新分类</a></div>
            </div>
            <?php
                if (Yii::$app->session->hasFlash('info')) {
                    echo Yii::$app->session->getFlash('info');
                }
            ?>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span3 sortable">
                            <span class="line"></span>分类ID</th>
                        <th class="span3 sortable">
                            <span class="line"></span>分类名称</th>
                        <th class="span3 sortable align-right">
                            <span class="line"></span>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php foreach ($cates as $cate): ?>
                    <tr class="first">
                        <td><?= $cate['cate_id'] ?></td>
                        <td><?= $cate['title'] ?></td>
                        <td class="align-right">
                            <a href="<?= Url::to(['category/mod', 'cate_id' => $cate['cate_id']]) ?>">编辑</a>
                            <a href="<?= Url::to(['category/del', 'cate_id' => $cate['cate_id']]) ?>">删除</a></td>
                    </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right"></div>
        </div>
    </div>
</div>