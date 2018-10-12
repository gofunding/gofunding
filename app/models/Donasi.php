<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "donasi".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $user_id
 * @property integer $kode_unik
 * @property integer $nominal_donasi
 * @property string $tanggal_donasi
 * @property integer $status
 * @property integer $is_anonim
 * @property string $komentar
 * @property string $phone_penerima_sms
 * @property integer $bank_id
 * @property string $transfer_sebelum
 * @property string $signature_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Bank $bank
 * @property Campaign $campaign
 * @property User $user
 * @property Donatur[] $donaturs
 */
class Donasi extends \yii\db\ActiveRecord
{

    const STATUS_BELUM_DIBAYAR = 1;
    const STATUS_SUKSES = 2;
    const STATUS_GAGAL = 3;
    const STATUS_MENUNGGU_VERIFIKASI = 4;

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
        return 'donasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nominal_donasi', 'bank_id'], 'required'],
            [['campaign_id', 'user_id', 'status', 'is_anonim', 'bank_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nominal_donasi'], 'number', 'min' => 20000],
            [['phone_penerima_sms'], 'number', 'message' => 'Nomor Telp/HP harus berupa angka'],
            [['tanggal_donasi', 'transfer_sebelum'], 'safe'],
            [['komentar'], 'string', 'max' => 140],
            [['phone_penerima_sms'], 'required', 'message' => 'Nomor Telp/HP tidak boleh kosong'],
            [['phone_penerima_sms'], 'string', 'max' => 50],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'id']],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['signature_key', 'string'],
            ['upload_bukti_transaksi', 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'campaign_id' => Yii::t('app', 'Campaign'),
            'user_id' => Yii::t('app', 'User'),
            // 'kode_unik' => Yii::t('app', 'Kode Unik'),
            'nominal_donasi' => Yii::t('app', 'Nominal Donasi'),
            'tanggal_donasi' => Yii::t('app', 'Tanggal Donasi'),
            'status' => Yii::t('app', 'Status'),
            'is_anonim' => Yii::t('app', 'Donasi sebagai anonim'),
            'komentar' => Yii::t('app', 'Teks saja, tanpa URL/kode html, dan emoticon.'),
            'phone_penerima_sms' => Yii::t('app', 'Phone Penerima Sms'),
            'bank_id' => Yii::t('app', 'Pilih Metode Pembayaran'),
            'transfer_sebelum' => Yii::t('app', 'Pastikan Anda transfer sebelum {Tgl & Waktu} WIB atau donasi Anda otomatis dibatalkan oleh sistem.'),
            'signature_key' => Yii::t('app', 'Signature Key'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['id' => 'bank_id']);
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
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonaturs()
    {
        return $this->hasMany(Donatur::className(), ['donasi_id' => 'id']);
    }

    public static function getStatus($param = null)
    {
        $arr = [
            0 => '',
            1 => 'Belum dibayar',
            2 => 'Sukses',
            3 => 'Gagal',
            4 => 'Menunggu Verifikasi'
        ];

        return empty($param) ? $arr : $arr[$param];
    }
}
