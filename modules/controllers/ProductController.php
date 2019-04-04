<?php

namespace app\modules\controllers;

use yii;
use app\models\Category;
use yii\web\Controller;
use app\models\Product;
use crazyfd\qiniu\Qiniu;
use yii\data\Pagination;

class ProductController extends Controller
{
    public $layout = 'layout';

    public function actionIndex()
    {
        $model = Product::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['product'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $products = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("index", compact('products', 'pager'));
    }

    /**
     * 商品添加操作
     * @return string
     */
    public function actionAdd()
    {
        $model       = new Product;
        $cate        = new Category;
        $list        = $cate->getOptions();
        unset($list[0]);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $pics = $this->upload();
            if (!$pics) {
                $model->addError('cover','封面不能为空');
            }else{
                $post['Product']['cover'] = $pics['cover'];
                $post['Product']['pics'] = $pics['pics'];
            }
            if ($pics && $model->add($post)) {
                Yii::$app->session->setFlash('info','添加成功');
            }else{
                Yii::$app->session->setFlash('info','添加失败');
            }
        }
        $model->ison = '';
        $opts        = $list;
        return $this->render('add', compact('model', 'opts'));
    }

    private function upload()
    {
        if ($_FILES['Product']['error']['cover'] > 0) {
            return false;
        }

        $zone = 'south_china';
        $qiniu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN, Product::BUCKET,$zone);
        $key = uniqid();
        $qiniu->uploadFile($_FILES['Product']['tmp_name']['cover'],$key);
        $cover = $qiniu->getLink($key);
        $pics =[];
        foreach ($_FILES['Product']['tmp_name']['pics'] as $k=>$file) {
            if ($_FILES['Product']['error']['pics'][$k] > 0) {
                continue;
            }
            $key = uniqid();
            $qiniu->uploadFile($file,$key);
            $pics[$key] = $qiniu->getLink($key);
        }
        $pics = json_encode($pics);
        return compact('cover','pics');
    }

    public function actionDetail()
    {
        return $this->render("detail");
    }
}



