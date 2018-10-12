<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "campaign".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $judul_campaign
 * @property integer $target_donasi
 * @property string $link
 * @property string $deadline
 * @property integer $kategori_id
 * @property integer $lokasi_id
 * @property string $cover_image
 * @property string $upload_file
 * @property string $video_url
 * @property string $deskripsi_singkat
 * @property string $deskripsi_lengkap
 * @property integer $terkumpul
 * @property integer $is_reached
 * @property integer $is_agree
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property CampaignKategori $kategori
 * @property KotaKabupaten $lokasi
 * @property User $user
 * @property CampaignUpdate[] $campaignUpdates
 * @property Donasi[] $donasis
 * @property Donatur[] $donaturs
 * @property DonaturOffline[] $donaturOfflines
 * @property DonaturOffline[] $donaturOfflines0
 * @property Fundraiser[] $fundraisers
 */
class Campaign extends \yii\db\ActiveRecord
{

    const IS_ACTIVE_DRAFT = 1;
    const IS_ACTIVE_LIFE = 2;
    const IS_ACTIVE_SELESAI = 3;
    const IS_REACHED_SUCCESS = 1;
    const IS_REACHED_FAILED = 2;

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
        return 'campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
// [['judul_campaign', 'target_donasi', 'deadline', 'kategori_id', 'deskripsi_singkat', 'deskripsi_lengkap', 'is_agree'], 'required'],
            [['user_id', 'kategori_id', 'lokasi_id', 'is_agree', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['target_donasi'], 'number', 'min' => 1000000, 'max' => 9999999999999],
            [['deadline'], 'safe'],
            [['deskripsi_lengkap'], 'string'],
            [['judul_campaign'], 'string', 'max' => 50],
            [['link', 'cover_image', 'upload_file', 'video_url'], 'string', 'max' => 255],
            [['video_url'], 'url', 'defaultScheme' => 'http'],
            ['terkumpul', 'number'],
            // checks if "primaryImage" is an uploaded image file in PNG, JPG or GIF format.
// the file size must be less than 1MB
            [['cover_image'], 'file', 'extensions' => ['png', 'jpg'], 'maxSize' => 1024 * 1024],
            [['upload_file'], 'file', 'extensions' => ['pdf'], 'maxSize' => 5120 * 5120],
            [['deskripsi_singkat'], 'string', 'max' => 160],
            [['kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => CampaignKategori::className(), 'targetAttribute' => ['kategori_id' => 'id']],
            [['lokasi_id'], 'exist', 'skipOnError' => true, 'targetClass' => KotaKabupaten::className(), 'targetAttribute' => ['lokasi_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['judul_campaign', 'target_donasi', 'deadline', 'kategori_id', 'cover_image', 'upload_file', 'deskripsi_singkat', 'deskripsi_lengkap', 'is_agree'], 'required', 'on' => 'create'],
            [['judul_campaign', 'target_donasi', 'deadline', 'kategori_id', 'deskripsi_singkat', 'deskripsi_lengkap'], 'required', 'on' => 'create'],
            [['terkumpul'], 'required', 'on' => 'payment'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['judul_campaign', 'target_donasi', 'deadline', 'kategori_id', 'cover_image', 'upload_file', 'video_url', 'deskripsi_singkat', 'deskripsi_lengkap', 'is_agree'];
        $scenarios['update'] = ['judul_campaign', 'target_donasi', 'deadline', 'kategori_id', 'video_url', 'deskripsi_singkat', 'deskripsi_lengkap'];
        $scenarios['contribute'] = ['terkumpul'];
        $scenarios['updateIsActive'] = ['is_active'];
        $scenarios['payment'] = ['terkumpul'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'judul_campaign' => Yii::t('app', 'Judul Campaign'),
            'target_donasi' => Yii::t('app', 'Target Donasi'),
            'link' => Yii::t('app', 'Link'),
            'deadline' => Yii::t('app', 'Deadline'),
            'kategori_id' => Yii::t('app', 'Kategori Campaign'),
            'lokasi_id' => Yii::t('app', 'Lokasi Penerima Dana'),
            'cover_image' => Yii::t('app', 'Cover Image'),
            'upload_file' => Yii::t('app', 'Upload Proposal'),
            'video_url' => Yii::t('app', 'Video Url'),
            'deskripsi_singkat' => Yii::t('app', 'Deskripsi Singkat'),
            'deskripsi_lengkap' => Yii::t('app', 'Deskripsi Lengkap'),
            'is_agree' => Yii::t('app', 'Setuju'),
            'is_active' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(CampaignKategori::className(), ['id' => 'kategori_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLokasi()
    {
        return $this->hasOne(KotaKabupaten::className(), ['id' => 'lokasi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignUpdates()
    {
        return $this->hasMany(CampaignUpdate::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonasis()
    {
        return $this->hasMany(Donasi::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonaturs()
    {
        return $this->hasMany(Donatur::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonaturOfflines()
    {
        return $this->hasMany(DonaturOffline::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonaturOfflines0()
    {
        return $this->hasMany(DonaturOffline::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFundraisers()
    {
        return $this->hasMany(Fundraiser::className(), ['campaign_id' => 'id']);
    }

    public static function getDaftarLokasi($params = null)
    {
        $data = Yii::$app->db->createCommand("SELECT kk.id, concat(kk.nama, ', ', p.nama) AS lokasi FROM kota_kabupaten kk LEFT JOIN provinsi p ON p.id = kk.provinsi_id")->queryAll();

        return ArrayHelper::map($data, 'id', 'lokasi');
    }

    public static function getStatus($param = null)
    {
        $arr = [
// '1' => 'Draft',
            '2' => 'Live',
            '3' => 'Selesai',
            '4' => 'Di tolak',
            '5' => 'Review'
        ];

        return empty($param) ? $arr : $arr[$param];
    }

    public function cekIsReached($id)
    {

        if (($model = Campaign::findOne(['id' => $id])) !== null) {
            $transaction = Yii::$app->db->beginTransaction();

            if ($model->terkumpul >= $model->target_donasi) {
                $model->is_reached = self::IS_REACHED_SUCCESS;
            } else {
                $model->is_reached = self::IS_REACHED_FAILED;
            }

            if ($model->save()) {
                $transaction->commit();

                return true;
            } else {
                $transaction->rollBack();

                return false;
            }
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }
}
