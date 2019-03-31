<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $cate_id
 * @property string $title
 * @property string $parent_id
 * @property string $create_time
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['parent_id', 'required', 'message' => '上级分类不能为空'],
            ['title', 'required', 'message' => '标题不能为空'],
            ['create_time', 'safe'],
            ['title', 'unique', 'message' => '标题已经添加', 'on' => ['add']],

//            [['parent_id', 'create_time'], 'integer'],
//            [['title'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cate_id' => '分类ID',
            'title' => '分类名称',
            'parent_id' => '上级分类',
            'create_time' => '创建时间',
        ];
    }

    /**
     * 添加分类数据
     * @param $data
     * @return bool
     */
    public function add($data)
    {
        $this->scenario = 'add';
        $data['Category']['create_time'] = time();
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }

    /**
     * 获取所有分类数据
     * @return 返回分类数据
     */
    public function getData()
    {
        $cates = self::find()->all();
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    /**
     * 整理所有分类数据
     * @param $cates 所有分类数据
     * @param int $pid 父级ID
     * @return array
     */
    public function getTree($cates, $pid=0)
    {
        $tree = [];
        foreach ($cates as $cate) {
            if ($cate['parent_id'] == $pid){
                $tree[] = $cate;
                $tree = array_merge($tree ,$this->getTree($cates, $cate['cate_id']));
            }
        }
        return $tree;
    }

    /**
     * 加分类数据前缀
     * @param $data
     * @param string $p
     * @return array
     */
    public function setPrefix($data, $p = '|----')
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while ($val = current($data)) {
            $key = key($data);
            if ($key > 0) {
                if ($data[$key-1]['parent_id'] != $val['parent_id']) {
                    $num ++;
                }
            }
            if (array_key_exists($val['parent_id'], $prefix)) {
                $num = $prefix[$val['parent_id']];
            }
            $val['title'] = str_repeat($p, $num).$val['title'];
            $prefix[$val['parent_id']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = [0 => '添加顶级分类'];
        foreach ($tree as $cate) {
            $options[$cate['cate_id']] = $cate['title'];
        }
        return $options;
    }

    public function getTreeList()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        return $tree;
    }

    public static function getMenu()
    {
        $top = self::find()->where('parent_id = :pid', [":pid" => 0])->limit(11)->orderby('create_time asc')->asArray()->all();
        $data = [];
        foreach((array)$top as $k=>$cate) {
            $cate['children'] = self::find()->where("parent_id = :pid", [":pid" => $cate['cate_id']])->limit(10)->asArray()->all();
            $data[$k] = $cate;
        }
        return $data;
    }
}
