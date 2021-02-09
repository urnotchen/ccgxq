<?php
namespace frontend\models\forms;

use frontend\models\Deal;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
    public $approval_id;
    public $label_arr;


    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg,xls,doc,docx,xlsx', 'maxFiles' => 10],
            [['approval_id'], 'exist', 'targetClass' => 'frontend\models\Approval', 'targetAttribute' => 'id'],
            [['approval_id'],'integer', 'skipOnEmpty' => false],
            [['label_arr'],'string','skipOnEmpty' => false]
        ];
    }

    public function upload()
    {

        if ($this->validate()) {


            $today = date("Ymd");
            if(!is_dir('uploads/images/' .$today)){
                mkdir('uploads/images/' .$today,0777);
            }
            $file_arr = [];
            foreach ($this->imageFiles as $file) {
                $i = 0;
                $name = 'uploads/images/' .$today.'/'. time().rand(111111,999999) . '.' . $file->extension;
                $file->saveAs($name);
                $file_arr[$i] = $name;
            }
            Deal::addRecord($this->approval_id,serialize($file_arr),$this->label_arr);

            return true;
        } else {
            return false;
        }
    }
    public function attributeLabels()
    {
        return [
            'approval_id' => 'approval_id',
            'imageFiles' => 'imageFiles',
            'label_arr' => 'label_arr',
        ];
    }
}