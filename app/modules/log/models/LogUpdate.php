<?php

namespace app\modules\log\models;

use Yii;

/**
 * This is the model class for table "log_update".
 *
 * @property integer $id
 * @property integer $log_id
 * @property string $date
 * @property integer $uid
 * @property string $username
 * @property string $ip
 * @property string $os_device
 * @property string $status
 * @property string $desc
 * @property string $data_json
 */
class LogUpdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_edit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_id', 'uid', 'username', 'ip', 'status', 'desc', 'data_json'], 'required'],
            [['log_id', 'uid'], 'integer'],
            [['date'], 'safe'],
            [['data_json'], 'string'],
            [['username', 'os_device'], 'string', 'max' => 128],
            [['ip'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 2],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'log_id' => Yii::t('app', 'Log ID'),
            'date' => Yii::t('app', 'Date'),
            'uid' => Yii::t('app', 'Uid'),
            'username' => Yii::t('app', 'Username'),
            'ip' => Yii::t('app', 'Ip'),
            'os_device' => Yii::t('app', 'Os Device'),
            'status' => Yii::t('app', 'Status'),
            'desc' => Yii::t('app', 'Desc'),
            'data_json' => Yii::t('app', 'Data Json'),
        ];
    }
}
