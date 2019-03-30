<p>你好SHOP商城的 <?= $admin_name?></p>

<p>您的找回密码链接如下：</p>

<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['admin/mangage/mailchangepass', 'timestamp' => $time, 'admin_name' => $admin_name, 'token' => $token])?>

<p><a href="<?= $url ?>"><?= $url ?></a></p>

<p>该链接5分钟内有效，请勿传递给别人！</p>

<p>该邮件由系统自动发送，请勿回复！</p>