<?php
/**
 * Created by PhpStorm.
 * User: macmoming
 * Date: 2019/3/29
 * Time: 1:08 AM
 */
namespace app\models;
use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%users}}';
    }
}