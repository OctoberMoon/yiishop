<?php
    use yii\helpers\Url;
?>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>会员列表</h3>
                <div class="span10 pull-right">
                    <a href="/index.php?r=admin%2Fuser%2Freg" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新用户</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span3 sortable">
                            <span class="line"></span>用户名</th>
                        <th class="span3 sortable">
                            <span class="line"></span>真实姓名</th>
                        <th class="span2 sortable">
                            <span class="line"></span>昵称</th>
                        <th class="span3 sortable">
                            <span class="line"></span>性别</th>
                        <th class="span3 sortable">
                            <span class="line"></span>年龄</th>
                        <th class="span3 sortable">
                            <span class="line"></span>生日</th>
                        <th class="span3 sortable align-right">
                            <span class="line"></span>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php foreach ($users as $user): ?>
                    <tr class="first">
                        <td>
                            <img src="assets/admin/img/contact-img.png" class="img-circle avatar hidden-phone" />
                            <a href="#" class="name"><?= $user->user_name ?></a>
                            <span class="subtext"><?= $user->user_email ?></span>
                        </td>
                        <td><?= isset($user->profile->true_name) ? $user->profile->true_name : '未填写' ?></td>
                        <td><?= isset($user->profile->nick_name) ? $user->profile->nick_name : '未填写' ?></td>
                        <td>
                            <?php if(!isset($user->profile->sex)) {
                                echo '未填写';
                            }elseif ($user->profile->sex == 0) {
                                echo '保密';
                            }elseif ($user->profile->sex == 1) {
                                echo '男';
                            }elseif ($user->profile->sex == 2) {
                                echo '女';
                            } ?>
                        </td>
                        <td><?= isset($user->profile->age) ? $user->profile->age : '未填写' ?></td>
                        <td><?= isset($user->profile->birthday) ? $user->profile->birthday : '未填写' ?></td>
                        <td class="align-right">
                            <a href="<?= Url::to(['user/del', 'user_id' => $user->user_id]) ?>">删除</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right"></div>
            <!-- end users table --></div>
    </div>
</div>
<!-- end main container -->