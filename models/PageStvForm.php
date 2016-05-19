<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Page save to version form
 */
class PageStvForm extends Model
{
    public $id;
    public $version_code;
    public $to_version_code;
    public $content;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'version_code', 'to_version_code', 'content'], 'required'],
            ['to_version_code', 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'version_code' => '当前版本号',
            'to_version_code' => '保存版本号',
            'content' => '内容',
        ];
    }
}
