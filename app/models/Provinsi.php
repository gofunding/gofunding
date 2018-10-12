<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "provinsi".
 *
 * @property integer $id
 * @property string $nama
 *
 * @property KotaKabupaten[] $kotaKabupatens
 */
class Provinsi extends \yii\db\ActiveRecord
{    
    // public function behaviors() {
    //     return [
    //         [
    //             'class' => BlameableBehavior::className(),
    //             'createdByAttribute' => 'created_by',
    //             'updatedByAttribute' => 'updated_by',
    //         ],
    //         'timestamp' => [
    //             'class' => 'yii\behaviors\TimestampBehavior',
    //             'attributes' => [
    //                 ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
    //                 ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
    //             ],
    //         ],
    //     ];
    // }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provinsi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nama' => Yii::t('app', 'Provinsi'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKotaKabupatens()
    {
        return $this->hasMany(KotaKabupaten::className(), ['provinsi_id' => 'id']);
    }

    public static function getListProvinsi() {
        $query = Yii::$app->db->createCommand('SELECT * FROM provinsi')->queryAll();

        return ArrayHelper::map($query, 'id', 'nama');
    }
}
