<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property string $id
 * @property string $true_name
 * @property integer $age
 * @property string $sex
 * @property string $birthday
 * @property string $nick_name
 * @property string $company
 * @property string $user_id
 * @property integer $create_time
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['age', 'user_id', 'create_time'], 'integer'],
            [['sex'], 'string'],
            [['birthday'], 'safe'],
            [['true_name', 'nick_name'], 'string', 'max' => 32],
            [['company'], 'string', 'max' => 100],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'true_name' => 'Truename',
            'age' => 'Age',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'nick_name' => 'Nickname',
            'company' => 'Company',
            'user_id' => 'Userid',
            'create_time' => 'Createtime',
        ];
    }
}
