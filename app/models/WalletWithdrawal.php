<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "wallet_withdrawal".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $nominal
 * @property integer $bank_id
 * @property string $nama_pemilik_rekening
 * @property integer $nomor_rekening
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $createed_by
 * @property integer $updated_by
 *
 * @property Bank $bank
 * @property User $user
 */
class WalletWithdrawal extends \yii\db\ActiveRecord
{    
    public function behaviors() {
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
        return 'wallet_withdrawal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'nominal', 'bank_id', 'nama_pemilik_rekening', 'nomor_rekening', 'status'], 'required'],
            [['user_id', 'nominal', 'bank_id', 'nomor_rekening', 'status', 'created_at', 'updated_at', 'createed_by', 'updated_by'], 'integer'],
            [['nama_pemilik_rekening'], 'string', 'max' => 50],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'nominal' => Yii::t('app', 'Nominal'),
            'bank_id' => Yii::t('app', 'Bank ID'),
            'nama_pemilik_rekening' => Yii::t('app', 'Nama Pemilik Rekening'),
            'nomor_rekening' => Yii::t('app', 'Nomor Rekening'),
            'status' => Yii::t('app', '1. Di proses, 2. Sukses, 3. Gagal'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'createed_by' => Yii::t('app', 'Createed By'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
