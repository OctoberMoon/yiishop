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
use yii\web\Controller;
use app\models\Category;

class CategoryController extends Controller
{
    public $layout = 'layout';
    public function actionList()
    {
        $model = new Category;
        $cates = $model->getOptions();

        return $this->render('cates',compact('cates'));
    }

    public function actionAdd()
    {
        $model = new Category();
        $list = $model->getOptions();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->add($post)) {
                Yii::$app->session->setFlash('info','添加成功');
            }
        }
        return $this->render('add',compact('model','list'));
    }

    public function actionDel()
    {
            $user_id = Yii::$app->request->get('user_id');
            if (Category::deleteAll('user_id = :id', [':id' => $user_id ])) {
                $this->redirect(['user/users']);
            }
    }
}