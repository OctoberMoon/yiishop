<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property string $prod_id
 * @property string $cate_id
 * @property string $title
 * @property string $descr
 * @property string $num
 * @property string $price
 * @property string $cover
 * @property string $pics
 * @property string $issale
 * @property string $saleprice
 * @property string $ishot
 * @property integer $create_time
 */
class Product extends \yii\db\ActiveRecord
{

    const AK = '8povu4_cLefqa3QcS7vQI2L7caFoGq7oiyCVS5mN';
    const SK = 'hnnXZ_24PKwpQsFS6t3eYjt-NzaxO0eG4Yg8EzMM';
    const DOMAIN = 'ppa6qi2pu.bkt.clouddn.com';
    const BUCKET = 'test';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required', 'message' => '标题不能为空'],
            ['descr', 'required', 'message' => '描述不能为空'],
            ['cate_id', 'required', 'message' => '分类不能为空'],
            ['price', 'required', 'message' => '单价不能为空'],
            [['price','saleprice'], 'number', 'min' => 0.01, 'message' => '价格必须是数字'],
            ['num', 'integer', 'min' => 0, 'message' => '库存必须是数字'],
            [['cover'], 'required'],
//            [['cate_id', 'num', 'createtime'], 'integer'],
//            [['price', 'saleprice'], 'number'],
//            [['title', 'cover'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cate_id' => '分类名称',
            'title'  => '商品名称',
            'descr'  => '商品描述',
            'price'  => '商品价格',
            'ishot'  => '是否热卖',
            'issale' => '是否促销',
            'saleprice' => '促销价格',
            'num'    => '库存',
            'cover'  => '图片封面',
            'pics'   => '商品图片',
            'ison'   => '是否上架',
        ];
    }

    public function add($data)
    {
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }
}
