<?php
/**
 * Created by PhpStorm.
 * User: macmoming
 * Date: 2019/3/29
 * Time: 1:08 AM
 */
namespace app\modules\models;
use yii\db\ActiveRecord;

class Admin extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%admin}}';
    }
}