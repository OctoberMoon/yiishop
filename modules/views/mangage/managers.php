<?php
 use yii\helpers\Url;
?>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>管理员列表</h3>
                <div class="span10 pull-right">
                    <a href="<?= Url::to(['mangage/reg']) ?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新管理员</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span2">管理员ID</th>
                        <th class="span2">
                            <span class="line"></span>管理员账号</th>
                        <th class="span2">
                            <span class="line"></span>管理员邮箱</th>
                        <th class="span3">
                            <span class="line"></span>最后登录时间</th>
                        <th class="span3">
                            <span class="line"></span>最后登录IP</th>
                        <th class="span2">
                            <span class="line"></span>添加时间</th>
                        <th class="span2">
                            <span class="line"></span>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php foreach ($managers as $manager): ?>
                    <tr>
                        <td><?= $manager->admin_id; ?></td>
                        <td><?= $manager->admin_name; ?></td>
                        <td><?= $manager->admin_email; ?></td>
                        <td><?= date('Y-m-d H:i:s',$manager->login_time); ?></td>
                        <td><?= long2ip($manager->login_ip); ?></td>
                        <td><?= date('Y-m-d H:i:s',$manager->create_time); ?></td>
                        <td class="align-right">
                            <a href="<?= Url::to(['mangage/del', 'adminid' => $manager->admin_id]) ?>">删除</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (Yii::$app->session->hasFlash('info')) {
                    echo Yii::$app->session->getFlash('info');
                }?>
            </div>
            <div class="pagination pull-right">
                <?= yii\widgets\LinkPager::widget(['pagination' => $pager, 'prevPageLabel' => '&#8249', 'nextPageLabel' => '&#8250'])?>
            </div>
            <!-- end users table -->
            </div>
    </div>
</div>
<!-- end main container -->