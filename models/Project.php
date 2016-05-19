<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property string $members
 * @property string $password
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Project extends \yii\db\ActiveRecord
{
    var $members_array = [];

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public static $config_status = [
        self::STATUS_DELETED => '无效',
        self::STATUS_ACTIVE => '有效'
    ];

    public static $config_status_icon = [
        self::STATUS_DELETED => '<i class="glyphicon glyphicon-remove"></i>',
        self::STATUS_ACTIVE => '<i class="glyphicon glyphicon-ok"></i>',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'required'],
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['description', 'members'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 6],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],

            ['members_array', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'user_id' => '用户ID',
            'name' => '名称',
            'description' => '描述',
            'members' => '成员',
            'password' => '密码',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',

            'members_array' => '成员',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public static function getOptions()
    {
        return ArrayHelper::map(self::find()->select(['id', 'name'])->where(['user_id' => Yii::$app->user->identity->id, 'status' => self::STATUS_ACTIVE])->asArray()->all(), 'id', 'name');
    }
}
