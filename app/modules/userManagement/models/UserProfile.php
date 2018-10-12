<?php

namespace app\modules\userManagement\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $no_telp
 * @property string $avatar
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord {

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
    public static function tableName() {
	return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
	return [
	    [['firstname'], 'required'],
	    [['firstname', 'lastname', 'no_telp'], 'string', 'max' => 50],
	    [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
	    [['firstname'], 'required', 'on' => 'create'],
	    ['no_telp', 'number'],
	];
    }

    public function scenarios() {
	$scenarios = parent::scenarios();
	$scenarios['create'] = ['firstname', 'lastname', 'no_telp'];
	$scenarios['update-profile'] = ['firstname', 'lastname', 'no_telp', 'imageFile'];

	return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
	return [
	    'user_id' => Yii::t('app', 'User ID'),
	    'firstname' => Yii::t('app', 'Firstname'),
	    'lastname' => Yii::t('app', 'Lastname'),
	    'no_telp' => Yii::t('app', 'No Telp'),
	    'avatar' => Yii::t('app', 'Avatar'),
	];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
	return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAvatar() {
	if (!empty($this->avatar) && file_exists(Yii::$app->params['uploadsPath'] . '/avatar/' . $this->avatar)) {
	    return Yii::$app->params['uploadsUrl'] . '/avatar/' . $this->avatar;
	} else {
	    return Yii::$app->params['defaultImage'];
	}
    }

    public function upload() {
	if ($this->validate()) {
	    $this->imageFile->saveAs('uploads/avatar/' . $this->avatar);

	    return true;
	} else {
	    return false;
	}
    }

    public static function getImageAvatar() {
	if (!empty(Yii::$app->user->identity->userProfile->avatar) && file_exists(Yii::$app->params['uploadsPath'] . '/avatar/' . Yii::$app->user->identity->userProfile->avatar)) {
	    return Yii::$app->params['uploadsUrl'] . '/avatar/' . Yii::$app->user->identity->userProfile->avatar;
	} else {
	    return Yii::$app->params['defaultImage'];
	}
    }

}
