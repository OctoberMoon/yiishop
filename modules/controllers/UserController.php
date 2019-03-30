<?php
/**
 * Created by PhpStorm.
 * User: macmoming
 * Date: 2019/3/30
 * Time: 4:58 PM
 */
namespace app\modules\controllers;

use Yii;
use yii\data\Pagination;
use app\models\User;
use app\models\Profile;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionUsers()
    {
        $model = User::find()->joinWith('profile');
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['user'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();
        $this->layout = 'layout';
        return $this->render('users', [
            'users' => $users,
            'pager' => $pager,
        ]);
    }

    public function actionReg()
    {
        $this->layout = 'layout';
        $model = new User();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info', '添加成功！');
            }
        }

        $model->user_pass = '';
        $model->repass = '';
        return $this->render('reg', [
            'model' => $model,
        ]);
    }

    public function actionDel()
    {
            $user_id = Yii::$app->request->get('user_id');
            if (User::deleteAll('user_id = :id', [':id' => $user_id ])) {
                $this->redirect(['user/users']);
            }
    }
}