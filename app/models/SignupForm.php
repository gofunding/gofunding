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
class SignupForm extends Model
{

    public $nama_lengkap;
    public $username;
    public $email;
    public $password;
    public $repeatPassword;
    public $is_community;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            // ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'NPM/NIK ini sudah digunakan.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'required', 'message' => 'NPM/NIK tidak boleh kosong'],
            ['email', 'trim'],
            [['email', 'repeatPassword'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Email ini sudah digunakan.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['repeatPassword'], 'compare', 'compareAttribute' => 'password', 'message' => 'Password tidak sama.'],
            [['nama_lengkap'], 'string', 'max' => 255],
            [['nama_lengkap'], 'required', 'message' => 'Nama Anda / Komunitas tidak boleh kosong.'],
            ['is_community', 'integer']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $userProfile = new UserProfile();
        $userProfile->scenario = 'daftar';
        $userProfile->nama_lengkap = $this->nama_lengkap;
        $userProfile->is_community = $this->is_community;
        $transaction = Yii::$app->db->beginTransaction();

        if ($user->save()) {
            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole('User');
            $auth->assign($authorRole, $user->id);

            $userProfile->user_id = $user->id;
            if ($userProfile->save()) {
                $transaction->commit();
                return $user;
            }

            exit(var_dump($userProfile));
        }

        $transaction->rollBack();
        return null;
    }
}
