<?php

namespace app\components\loginAttempt;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginAttemptsBehavior
 *
 * @author haifahrul
 */
use Yii;
use yii\base\Model;
use app\components\loginAttempt\LoginAttempt;

class LoginAttemptBehavior extends \yii\base\Behavior {

    public $attempts = 3;
    public $duration = 300;
    public $disableDuration = 900;
    public $usernameAttribute = 'username';
    public $passwordAttribute = 'password';
    public $message = 'You have exceeded the password attempts.';
    private $_attempt;

    public function events() {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            Model::EVENT_AFTER_VALIDATE => 'afterValidate',
        ];
    }

    public function beforeValidate() {
        if ($this->_attempt = LoginAttempt::find()->where(['key' => $this->key])->andWhere(['>', 'reset_at', date('r')])->one()) {
            if ($this->_attempt->amount >= $this->attempts) {
                $this->owner->addError($this->passwordAttribute, $this->message);
            }
        }
    }

    public function afterValidate() {
        if ($this->owner->hasErrors($this->passwordAttribute)) {
            if (!$this->_attempt) {
                $this->_attempt = new LoginAttempt;
                $this->_attempt->key = $this->key;
            }

            $this->_attempt->amount += 1;

            if ($this->_attempt->amount >= $this->attempts) {
                $this->_attempt->reset_at = date('r', strtotime('+' . $this->disableDuration . ' seconds'));
                Yii::$app->db->createCommand('UPDATE `user` SET `status`=:status WHERE `username`=:username AND `status`!=:is_status')
                        ->bindValues([':status' => 5, ':is_status' => 0, ':username' => $this->key])
                        ->execute();
            } else {
                $this->_attempt->reset_at = date('r', strtotime('+' . $this->duration . ' seconds'));
            }

            $this->_attempt->save();
        } else if (!$this->owner->hasErrors($this->passwordAttribute)) {
            Yii::$app->db->createCommand()->delete('login_attempt', '`key` = :key')->bindValue(':key', $this->getKey())->execute();
        }
    }

    public function getKey() {
//        return sha1($this->owner->{$this->usernameAttribute});
        return $this->owner->{$this->usernameAttribute};
    }

}
