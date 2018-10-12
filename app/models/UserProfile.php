<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property string $npm
 * @property string $firstname
 * @property string $lastname
 * @property string $no_telp
 * @property string $avatar
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{

    public $imageFile;
    public $email;

    //   public function behaviors() {
    // return [
    //     [
    // 	'class' => BlameableBehavior::className(),
    // 	'createdByAttribute' => 'created_by',
    // 	'updatedByAttribute' => 'updated_by',
    //     ],
    //     'timestamp' => [
    // 	'class' => 'yii\behaviors\TimestampBehavior',
    // 	'attributes' => [
    // 	    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
    // 	    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
    // 	],
    //     ],
    // ];
    //   }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_telp'], 'required'],
            [['npm', 'firstname', 'lastname', 'no_telp'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['nama_lengkap'], 'required', 'on' => 'create'],
            [['theme'], 'required', 'on' => 'update-theme'],
            ['no_telp', 'number'],
            [['avatar'], 'string', 'max' => 225],
            ['bio_singkat', 'string', 'max' => 500],
            ['lokasi_id', 'integer'],
            ['imageFile', 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'img'], 'maxSize' => 1024 * 1024],
            [['nama_lengkap'], 'required', 'on' => 'update-profile'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['daftar'] = ['nama_lengkap', 'is_community'];
        $scenarios['create'] = ['nama_lengkap', 'no_telp'];
        $scenarios['update-profile'] = ['nama_lengkap', 'bio_singkat', 'no_telp', 'avatar', 'lokasi_id'];
        $scenarios['campaign-create-form-step-3'] = ['no_telp'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'npm' => Yii::t('app', 'NPM'),
            'firstname' => Yii::t('app', 'Nama Depan'),
            'lastname' => Yii::t('app', 'Nama Belakang'),
            'no_telp' => Yii::t('app', 'Nomor Handphone'),
            'avatar' => Yii::t('app', 'Avatar'),
            'bio_singkat' => Yii::t('app', 'Alamat'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAvatar()
    {
        if (!empty($this->avatar) && file_exists(Yii::$app->params['uploadsPath'] . '/avatar/' . $this->avatar)) {
            return Yii::$app->params['uploadsUrl'] . '/avatar/' . $this->avatar;
        } else {
            return Yii::$app->params['defaultImage'];
        }
    }

    public static function getImageAvatar()
    {
        if (!empty(Yii::$app->user->identity->userProfile->avatar) && file_exists(Yii::$app->params['uploadsPath'] . '/avatar/' . Yii::$app->user->identity->userProfile->avatar)) {
            return Yii::$app->params['uploadsUrl'] . '/avatar/' . Yii::$app->user->identity->userProfile->avatar;
        } else {
            return Yii::$app->params['defaultImage'];
        }
    }

    public function getKotaKabupaten()
    {
        return $this->hasOne(KotaKabupaten::className(), ['id' => 'lokasi_id']);
    }

    public function getFullname()
    {
        return Yii::$app->user->identity->userProfile->firstname . ' ' . Yii::$app->user->identity->userProfile->lastname;
    }

    public function getLokasi()
    {
        if (!empty($this->lokasi_id)) {
            $lokasi = $this->kotaKabupaten->nama . ' - ' . $this->kotaKabupaten->provinsi->nama;
        } else {
            $lokasi = '-';
        }

        return $lokasi;
    }
}
