<p>你好! 恭喜你注册成功</p>

<p>您的账号：<?= $user_name ?></p>
<p>您的密码：<?= $user_pass ?></p>
快去登陆吧！
<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['member/auth'])?>
<p><a href="<?= $url ?>"><?= $url ?></a></p>
<p>该邮件由系统自动发送，请勿回复！</p>