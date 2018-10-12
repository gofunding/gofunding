<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    public $email;
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    //   public function behaviors() {
    // $behaviors = parent::behaviors();
    // $behaviors[] = [
    //     'class' => '\app\components\loginAttempt\LoginAttemptBehavior',
    //     // Amount of attempts in the given time period
    //     'attempts' => 3,
    //     // the duration, in seconds, for a regular failure to be stored for
    //     // resets on new failure in 5 minutes
    //     'duration' => 900,
    //     // the duration, in seconds, to disable login after exceeding `attemps` 15 minutes
    //     'disableDuration' => 900,
    //     // the attribute used as the key in the database
    //     // and add errors to
    //     'emailAttribute' => 'email',
    //     // the attribute to check for errors
    //     'passwordAttribute' => 'password',
    //     // the validation message to return to `usernameAttribute`
    //     'message' => 'Anda salah memasukkan email atau password selama 3x. Akun anda sementara di blok. Silahkan hubungi Administrator atau tunggu waktu reset ulang selama 15 menit.',
    // ];
    // return $behaviors;
    //   }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['password', 'username'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'message' => 'NIK/NPM harus number'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect NPM/NIK or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
