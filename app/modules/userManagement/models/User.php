<?php

namespace app\modules\userManagement\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\modules\userManagement\models\AuthAssignment;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord {

    public $new_password, $old_password, $repeat_password;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
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
    public function rules() {
        return [
            [['username'], 'required'],
            [['username', 'email', 'password_hash'], 'string', 'max' => 255],
            [['username', 'email'], 'unique'],
            [['email'], 'email'],
            ['status', 'integer'],
            [['old_password', 'new_password', 'repeat_password'], 'string', 'min' => 6],
            [['repeat_password'], 'compare', 'compareAttribute' => 'new_password'],
            [['new_password', 'repeat_password'], 'required', 'when' => function ($model) {
                    return (!empty($model->new_password));
                }, 'whenClient' => "function (attribute, value) {
                return ($('#user-new_password').val().length>0);
            }"],
            [['username', 'new_password', 'repeat_password'], 'required', 'on' => 'create'],
            [['new_password', 'repeat_password'], 'required', 'on' => 'change-password'],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['username', 'email', 'new_password', 'repeat_password', 'status'];
        $scenarios['change-password'] = ['new_password', 'repeat_password'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'new_password' => Yii::t('app', 'New Password'),
            'repeat_password' => Yii::t('app', 'Repeat Password'),
            'email' => 'Email',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles() {
        return $this->hasMany(AuthAssignment::className(), [
                    'user_id' => 'id',
        ]);
    }

    public function getUserProfile() {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    public static function getStatus($attr = null) {
        $data = [
            10 => Yii::t('app', 'Active'),
            5 => Yii::t('app', 'Banned'),
            0 => Yii::t('app', 'Inactive'),
        ];

        return !is_null($attr) ? $data[$attr] : $data;
    }

}
