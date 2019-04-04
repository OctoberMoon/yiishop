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

    /**
     * 分类列表
     * @return string
     */
    public function actionList()
    {
        $model = new Category;
        $cates = $model->getMenu();
        return $this->render('cates',compact('cates'));
    }

    /**
     * 添加分类操作
     * @return string
     */
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

    /**
     * 编辑分类操作
     * @return string
     */
    public function actionMod()
    {
        $model = new Category();
        $cate_id = Yii::$app->request->get('cate_id');
        $model = $model::findOne($cate_id);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('info','修改成功');
            }
        }
        $list = $model->getOptions();
        return $this->render('add', [
            'model' => $model,
            'list' => $list,
        ]);
    }

    /**
     * 删除分类操作
     */
    public function actionDel()
    {
        try{
            $cate_id = Yii::$app->request->get('cate_id');
            if (empty($cate_id)) {
                throw new \Exception('参数错误');
            }
            $data = Category::find()->where('parent_id = :pid',[":pid"=>$cate_id])->one();
            if ($data) {
                throw new \Exception('该分类下有子类，请先删除子类');
            }
            if (!Category::deleteAll('cate_id = :id', [':id' => $cate_id ])) {
                throw new \Exception('删除失败');
            }
        }catch (\Exception $e){
            Yii::$app->session->setFlash('info',$e->getMessage());
        }
        return $this->redirect(['category/list']);
    }
}