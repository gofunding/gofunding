<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "kota_kabupaten".
 *
 * @property integer $id
 * @property integer $provinsi_id
 * @property string $nama
 *
 * @property Campaign[] $campaigns
 * @property Provinsi $provinsi
 * @property UserProfile[] $userProfiles
 */
class KotaKabupaten extends \yii\db\ActiveRecord
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
        return 'kota_kabupaten';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provinsi_id', 'nama'], 'required'],
            [['provinsi_id'], 'integer'],
            [['nama'], 'string', 'max' => 50],
            [['provinsi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinsi::className(), 'targetAttribute' => ['provinsi_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'provinsi_id' => Yii::t('app', 'Provinsi'),
            'nama' => Yii::t('app', 'Kota/Kabupaten'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaign::className(), ['lokasi_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinsi()
    {
        return $this->hasOne(Provinsi::className(), ['id' => 'provinsi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['lokasi_id' => 'id']);
    }
}
