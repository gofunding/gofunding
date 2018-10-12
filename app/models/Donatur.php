<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "donatur".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $user_id
 * @property integer $donasi_id
 * @property integer $nominal_donasi
 * @property integer $biaya_administrasi
 * @property integer $donasi_bersih
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Campaign $campaign
 * @property Donasi $donasi
 * @property UserProfile $user
 */
class Donatur extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'donatur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['campaign_id', 'user_id', 'donasi_id', 'nominal_donasi', 'biaya_administrasi', 'donasi_bersih'], 'required'],
            [['campaign_id', 'user_id', 'donasi_id', 'nominal_donasi', 'biaya_administrasi', 'donasi_bersih', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['donasi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Donasi::className(), 'targetAttribute' => ['donasi_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'campaign_id' => Yii::t('app', 'Campaign ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'donasi_id' => Yii::t('app', 'Donasi ID'),
            'nominal_donasi' => Yii::t('app', 'Nominal Donasi'),
            'biaya_administrasi' => Yii::t('app', 'Biaya Administrasi'),
            'donasi_bersih' => Yii::t('app', 'Donasi Bersih'),
            'created_at' => Yii::t('app', 'Tanggal Donatur'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonasi()
    {
        return $this->hasOne(Donasi::className(), ['id' => 'donasi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'user_id']);
    }
}
