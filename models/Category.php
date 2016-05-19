<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $project_id
 * @property string $name
 * @property integer $sort_order
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Category extends \yii\db\ActiveRecord
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
        return '{{%category}}';
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
            [['user_id', 'project_id', 'status'], 'required'],
            [['user_id', 'project_id', 'sort_order', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 100],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['sort_order', 'default', 'value' => 0],
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
            'project_id' => '项目ID',
            'name' => '名称',
            'sort_order' => '排序',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public function getProject(){
        return $this->hasOne(Project::className(),['id'=>'project_id']);
    }

    public function getPages(){
        return $this->hasMany(Page::className(),['category_id'=>'id'])
            ->where(['version' => 'latest']);
    }

    public static function getOptions()
    {
        $categorys = self::find()->where(['user_id' => Yii::$app->user->identity->id, 'status' => self::STATUS_ACTIVE])->all();
        $data = [];
        if (!empty($categorys)) {
            foreach ($categorys as $category) {
                $data[$category->id] = $category->project->name.'---'.$category->name;
            }
        }
        return $data;
    }
}
