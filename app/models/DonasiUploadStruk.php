<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class DonasiUploadStruk extends Model {

    /**
     * @var UploadedFile
     */
    public $file;
    public $upload_bukti_transaksi;

    public function rules() {
        return [
                [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, pdf'],
        ];
    }

    public function upload() {
        if ($this->validate()) {
            $this->upload_bukti_transaksi = sha1($this->file->baseName . microtime()) . '.' . $this->file->extension;
            $this->file->saveAs(Yii::$app->params['uploadPath'] . '/bukti_transaksi/' . $this->upload_bukti_transaksi);
            return true;
        } else {
            return false;
        }
    }

}

?>