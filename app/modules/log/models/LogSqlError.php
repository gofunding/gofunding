<?php

namespace app\modules\log\models;

use Yii;

/**
 * This is the model class for table "log_sql_error".
 *
 * @property integer $id
 * @property string $sql_text
 * @property string $object_name
 * @property integer $error_number
 * @property integer $row_count
 * @property string $sql_state
 * @property string $error_message
 * @property string $description
 * @property integer $created_at
 * @property integer $created_by
 */
class LogSqlError extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_sql_error';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['error_number', 'row_count', 'created_at', 'created_by'], 'integer'],
            [['sql_text'], 'string', 'max' => 1000],
            [['object_name'], 'string', 'max' => 50],
            [['sql_state', 'error_message', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sql_text' => Yii::t('app', 'Sql Text'),
            'object_name' => Yii::t('app', 'Object Name'),
            'error_number' => Yii::t('app', 'Error Number'),
            'row_count' => Yii::t('app', 'Row Count'),
            'sql_state' => Yii::t('app', 'Sql State'),
            'error_message' => Yii::t('app', 'Error Message'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
    }
}
