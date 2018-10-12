<?php

namespace app\components\loginAttempt;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginAttempts
 *
 * @author haifahrul
 */

class LoginAttempt extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'login_attempt';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['timestampBehavior'] = [
            'class' => \yii\behaviors\TimestampBehavior::className(),
            'value' => new \yii\db\Expression('NOW()'),
        ];

        return $behaviors;
    }

    public function rules()
    {
        return [
            [['key'], 'required'],
        ];
    }
}
