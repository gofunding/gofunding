<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "wallet_mutasi".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $tanggal
 * @property integer $deskripsi
 * @property integer $debet
 * @property integer $kredit
 * @property integer $saldo
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $user
 */
class WalletMutasi extends \yii\db\ActiveRecord
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
        return 'wallet_mutasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'deskripsi', 'debet', 'kredit', 'saldo'], 'required'],
            [['user_id', 'deskripsi', 'debet', 'kredit', 'saldo', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tanggal'], 'safe'],
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
            'tanggal' => Yii::t('app', 'Tanggal'),
            'deskripsi' => Yii::t('app', '1. Top Up, 2. Penarikan Dana'),
            'debet' => Yii::t('app', 'Debet'),
            'kredit' => Yii::t('app', 'Kredit'),
            'saldo' => Yii::t('app', 'Saldo'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
