<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "campaign_kategori".
 *
 * @property integer $id
 * @property string $nama
 * @property integer $is_active
 *
 * @property Campaign[] $campaigns
 */
class CampaignKategori extends \yii\db\ActiveRecord
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
        return 'campaign_kategori';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'is_active'], 'required'],
            [['is_active'], 'integer'],
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
            'nama' => Yii::t('app', 'Nama'),
            'is_active' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaign::className(), ['kategori_id' => 'id']);
    }

    public static function getDaftarKategori($params = null) {
        // if (is_null($params)) {
            $data = Yii::$app->db->createCommand('SELECT id, nama FROM campaign_kategori WHERE is_active=1')->queryAll();
            $result = ArrayHelper::map($data, 'id', 'nama');
        // } else {
        //     $data = Yii::$app->db->createCommand('SELECT id, nama FROM campaign_kategori WHERE is_active=1 && id=:id')->bindValue(':id', $params)->queryAll();

        //     $result = ArrayHelper::map($data, 'id', 'nama');
        // }

        return $result;
    }
}
