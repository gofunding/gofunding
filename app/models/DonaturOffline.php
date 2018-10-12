<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "donatur_offline".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $user_id
 * @property string $nama_donatur
 * @property integer $nominal_donasi
 * @property string $tanggal_donasi
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Campaign $campaign
 * @property Campaign $user
 */
class DonaturOffline extends \yii\db\ActiveRecord
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
        return 'donatur_offline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_donatur', 'nominal_donasi', 'tanggal_donasi'], 'required'],
            [['campaign_id', 'user_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            ['nominal_donasi', 'number'],
            ['tanggal_donasi', 'safe'],
            [['nama_donatur'], 'string', 'max' => 50],
//            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'nama_donatur' => Yii::t('app', 'Nama Donatur'),
            'nominal_donasi' => Yii::t('app', 'Nominal Donasi'),
            'tanggal_donasi' => Yii::t('app', 'Tanggal Donasi'),
            'created_at' => Yii::t('app', 'Created At'),
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
    public function getUser()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'user_id']);
    }
}
