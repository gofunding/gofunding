<?php

namespace app\modules\log\models;

use Yii;

/**
 * This is the model class for table "log_login".
 *
 * @property integer $id
 * @property integer $log_id
 * @property integer $uid
 * @property string $username
 * @property string $date
 * @property string $ip
 * @property string $os_device
 * @property string $user_agent
 * @property string $status
 * @property string $desc
 * @property string $data_json
 */
class Login extends \yii\db\ActiveRecord {

    public $username;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'log_login';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['log_id', 'date', 'ip', 'status'], 'required'],
            [['log_id', 'uid'], 'integer'],
            [['date', 'data_json'], 'safe'],
            [['ip'], 'string', 'max' => 30],
            [['os_device', 'username'], 'string', 'max' => 1000],
            [['user_agent'], 'string', 'max' => 1024],
            [['status'], 'string', 'max' => 2],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'log_id' => Yii::t('app', 'Log ID'),
            'date' => Yii::t('app', 'Date'),
            'uid' => Yii::t('app', 'UID'),
            'username' => Yii::t('app', 'Username'),
            'ip' => Yii::t('app', 'IP'),
            'os_device' => Yii::t('app', 'OS Device'),
            'user_agent' => Yii::t('app', 'User Agent'),
            'status' => Yii::t('app', 'Status'),
            'desc' => Yii::t('app', 'Desc'),
            'data_json' => Yii::t('app', 'Data JSON'),
        ];
    }

    public static function saveLog($action) {
        if (Yii::$app->response->getStatusCode() === 302) { // Found
            $status = 1;
        } else {
            $status = 0;
        }

        if ($post = Yii::$app->request->post('LoginForm')) {
            $username = isset($post['username']) ? $post['username'] : $post['email'];
        } else if (!empty(Yii::$app->user->identity->username)) {
            $username = Yii::$app->user->identity->username;
        } else if (!empty(Yii::$app->user->identity->email)) {
            $username = Yii::$app->user->identity->email;
        } else {
            $username = null;
        }

        if (!empty($username)) {
            $detect = Yii::$app->detect;
            $result['username'] = $username;
            $result['email'] = !empty(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : null;
            $result['action'] = $action->id;
            $result['ip'] = $ip = self::getClientIp();
            $result['deviceType'] = $deviceType = $detect::deviceType();
            $result['os'] = $os = $detect::os();
            $result['browser'] = $browser = $detect::browser();
            $result['status'] = $status;
            $result['desc'] = $desc = $action->id;
            $result['time'] = date('Y-m-d H:i:s');

            $query = "INSERT INTO log_login (
	`log_id`,        
	`username`,
	`ip`,
	`os_device` ,
	`status`,
	`desc`,
	`data_json`) VALUES (:log_id, :username, :ip, :os_device, :status, :desc, :data_json)";

            Yii::$app->db->createCommand($query)->bindValues([
                ':log_id' => NULL,
                ':username' => $username,
                ':ip' => $ip,
                ':os_device' => $os . ', ' . $deviceType . ', ' . $browser,
                ':status' => $status,
                ':desc' => $desc,
                'data_json' => json_encode($result, JSON_PRETTY_PRINT)
            ])->execute();
        }
    }

    public static function getClientIp() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}
