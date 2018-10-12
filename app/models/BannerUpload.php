<?php 
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class BannerUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $filename;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->filename = sha1($this->imageFile->baseName . microtime()) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(Yii::$app->params['uploadPath'] . '/banner/' . $this->filename);
            return true;
        } else {
            return false;
        }
    }
}
?>