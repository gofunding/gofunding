<?php

namespace app\modules\log\models;

use Yii;

/**
 * This is the model class for table "log_events".
 *
 * @property integer $id
 * @property string $guid
 * @property string $event_name
 * @property integer $executed_at
 * @property integer $executed_by
 * @property integer $next_execute
 */
class LogEvents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'executed_at'], 'required'],
            [['executed_at', 'executed_by', 'next_execute'], 'integer'],
            [['guid'], 'string', 'max' => 50],
            [['event_name'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'guid' => Yii::t('app', 'Guid'),
            'event_name' => Yii::t('app', 'Event Name'),
            'executed_at' => Yii::t('app', 'Executed At'),
            'executed_by' => Yii::t('app', 'Executed By'),
            'next_execute' => Yii::t('app', 'Next Execute'),
        ];
    }
}
