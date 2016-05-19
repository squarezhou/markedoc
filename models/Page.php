<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $version
 * @property string $version_code
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Page extends \yii\db\ActiveRecord
{
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
        return '{{%page}}';
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
            [['user_id', 'category_id', 'content', 'version_code', 'status'], 'required'],
            [['page_id', 'user_id', 'category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['version', 'version_code'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 100],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'page_id' => '页面ID',
            'user_id' => '用户ID',
            'category_id' => '分类ID',
            'version' => '版本',
            'version_code' => '版本号',
            'title' => '标题',
            'content' => '内容',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public function getCategory(){
        return $this->hasOne(Category::className(),['id'=>'category_id']);
    }

    public function getVersions(){
        return Page::find()->select(['id', 'version_code'])->where(['page_id' => $this->page_id])->all();
    }
}
