<?php
/**
 * Created by PhpStorm.
 * User: macmoming
 * Date: 2019/3/30
 * Time: 2:15 AM
 */
namespace app\modules\controllers;

use Yii;
use app\modules\models\Admin;
use yii\data\Pagination;
use yii\web\Controller;

class MangageController extends Controller
{
    public $layout = false;
    public function actionMailchangepass()
    {
        $time = Yii::$app->request->get("timestamp");
        $adminuser = Yii::$app->request->get("admin_name");
        $token = Yii::$app->request->get("token");

        $model = new Admin();
        $myToken = $model->createToken($adminuser,$time);
        if ($token != $myToken) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        if (time() - $time > 300) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changePass($post)) {
                Yii::$app->session->setFlash('info','密码修改成功!');
                $this->redirect(['public/login']);
            }
        }

        $model->admin_name = $adminuser;
        return $this->render('mailchangepass', ['model' => $model]);
    }

    //显示管理员列表
    public function actionManagers()
    {
        $this->layout = 'layout';
        $model = Admin::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['manage'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('managers', [
            'managers' => $managers,
            'pager' => $pager,
        ]);
    }

    //添加管理员
    public function actionReg()
    {
        $this->layout = 'layout';
        $model = new Admin();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info','添加成功');
                $this->redirect(['mangage/mangages']);

            }else{
                Yii::$app->session->setFlash('info','添加失败');
            }
        }

        $model->admin_pass = '';
        $model->repass = '';
        $model->login_ip = '';

        return $this->render('reg', [
            'model' => $model,
        ]);
    }

    //删除管理员
    public function actionDel()
    {
        $adminid = (int)Yii::$app->request->get('adminid');
        if (empty($adminid)) {
            $this->redirect(['mangage/managers']);
        }
        $model = new Admin();
        if($model->deleteAll('adminid = :id', [':id' => $adminid])) {
            Yii::$app->session->setFlash('info', '删除成功!');
            $this->redirect(['mangage/managers']);
        }
    }

    //修改邮箱
    public function actionChangeemail()
    {
        $this->layout = 'layout';
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changeEmail($post)) {
                Yii::$app->session->setFlash('info','修改成功');
            }
        }
        $model->adminpass = '';
        return $this->render('changeemail', [
            'model' => $model,
        ]);
    }

    //修改密码
    public function actionChangepass()
    {
        $this->layout = 'layout';
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changePass($post)) {
                Yii::$app->session->setFlash('info','修改成功！');
            }
        }
        $model->adminpass = '';
        $model->repass = '';
        return $this->render('changepass', [
            'model' => $model,
        ]);
    }


}
