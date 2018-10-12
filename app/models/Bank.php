<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "bank".
 *
 * @property integer $id
 * @property string $path_logo
 * @property string $nama_bank
 * @property string $nama_payment
 * @property string $biaya_per_transaksi
 * @property string $va_number
 * @property integer $is_active
 * @property integer $is_va
 *
 * @property Donasi[] $donasis
 * @property WalletTopUp[] $walletTopUps
 * @property WalletWithdrawal[] $walletWithdrawals
 */
class Bank extends \yii\db\ActiveRecord {

    public function behaviors() {
        return [
                // [
                //     'class' => BlameableBehavior::className(),
                //     'createdByAttribute' => 'created_by',
                //     'updatedByAttribute' => 'updated_by',
                // ],
                // 'timestamp' => [
                //     'class' => 'yii\behaviors\TimestampBehavior',
                //     'attributes' => [
                //         ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                //         ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                //     ],
                // ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'bank';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['nama_bank', 'nama_payment', 'biaya_per_transaksi'], 'required'],
                [['biaya_per_transaksi', 'is_active', 'is_va'], 'integer'],
                [['nama_bank', 'nama_payment'], 'string', 'max' => 50],
                [['va_number'], 'string', 'max' => 255],
                [['path_logo'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'path_logo' => Yii::t('app', 'Logo'),
            'nama_bank' => Yii::t('app', 'Nama Bank'),
            'nama_payment' => Yii::t('app', 'Nama Payment'),
            'biaya_per_transaksi' => Yii::t('app', 'Biaya Per Transaksi'),
            'va_number' => Yii::t('app', 'VA Number'),
            'is_va' => Yii::t('app', 'Is VA'),
            'is_active' => Yii::t('app', 'Is Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonasis() {
        return $this->hasMany(Donasi::className(), ['bank_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWalletTopUps() {
        return $this->hasMany(WalletTopUp::className(), ['bank_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWalletWithdrawals() {
        return $this->hasMany(WalletWithdrawal::className(), ['bank_id' => 'id']);
    }

    public static function getIsActive($param = null) {
        $arr = [
            1 => Yii::t('app', 'Active'),
            2 => Yii::t('app', 'Not Active'),
        ];
        return !empty($param) ? $arr[$param] : $arr;
    }

    public static function getIsVA($param = null) {
        $arr = [
            1 => Yii::t('app', 'Using VA'),
            2 => Yii::t('app', 'Not Using VA'),
        ];
        return !empty($param) ? $arr[$param] : $arr;
    }

    /**
     * Example data JSON
     * $param = '{ "bni_va": { "va_number": "12345678" ,"receiver": "RECEIVER"} }';
     */
    public static function getVaNumber($param) {
        if (!empty($param)) {
            $param = array_values((array) json_decode($param));
            $vaNumber = (array) $param[0];

            return ' - No. Rek ' . $vaNumber['va_number'];
        }
    }

}
