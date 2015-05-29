<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property integer $active
 * @property integer $createdAt
 * @property integer $hasImage
 * @property string $imageExtension
 *
 * @property Category[] $categories
 */

use yii\behaviors\TimestampBehavior;
use app\models\Category;
use app\models\CategoryNews;
use yii\web\UploadedFile;
use Yii;

class News extends \yii\db\ActiveRecord
{
    public $imageFile = null;
    public $oldImageFilename = null;

    public static function tableName()
    {
        return '{{%news}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => false
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Заголовок не должен быть пустым'],
            [
                ['title'], 
                'string', 
                'min' => 1, 
                'max' => 255,
                'tooShort' => 'Заголовок слишком короткий',
                'tooLong' => 'Заголовок слишком длинный'
            ],
            
            [['description'], 'required', 'message' => 'Описание не должно быть пустым'],
            [
                ['description'], 
                'string', 
                'min' => 1, 
                'max' => 255,
                'tooShort' => 'Описание слишком короткое',
                'tooLong' => 'Описание слишком длинное'
            ],
            
            [['text'], 'string'],
            
            [['active'], 'required'],
            [
                ['active'], 
                'boolean', 
                'strict' => true, 
                'message' => 'Недопустимое значение'
            ], //TODO#
            
            [['createdAt'], 'required'],
            [['createdAt'], 'integer'],

            [['hasImage'], 'required'],
            [
                ['hasImage'], 
                'boolean', 
                'strict' => true, 
                'message' => 'Недопустимое значение'
            ], //TODO#
            
            [['imageExtension'], 'required'],
            [
                ['imageExtension'],
                'string', 
                'max' => 5,
                'tooLong' => 'Расширение изображения слишком длинное'
            ],
            
            [['imageFile'], 'file'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'text' => 'Текст',
            'active' => 'Активна',
            'createdAt' => 'Создана',
            'hasImage' => 'Изображение',
            'imageExtension' => 'Расширение изображения',
            'imageFile' => 'Файл изображения',
            'imageFilename' => 'Имя файла изображения',
            'categories' => 'Категории',
        ];
    }
    
    public static function getSaveImagesPath() {
        return Yii::getAlias('@imagesNews'); 
    }
    
    public function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'idCategory'])
            ->viaTable('{{%categorynews}}', ['idNews' => 'id']);
    }
    
    // Возвращает имя файла(с расширеним) без пути. 
    // Если к новости не привязан файл, вернёт пустую строку. 
    public function getImageFilename() { 
        if (!$this->hasImage) {
            return '';
        } else {
            return self::getImageFilenameForModel($this);
        }
    }
    
    // Возвращает имя файла, который должен соответствовать модели, с расширеним 
    // без пути. Файл не обязательно существует.
    protected static function getImageFilenameForModel($model) {
        $extension = '';
        if ($model->imageExtension !== '') {
            $extension .= '.'.$model->imageExtension;
        }
        return $model->id.$extension;   
    }
    
    public function getImageUrl() {
        return Yii::getAlias('@imagesNewsUrl').'/'.$this->imageFileName;
    }
    
    protected function beforeSave() {
        $file = UploadedFile::getInstance($this, 'imageFile');
        $needUploadImageFile = $file !== null;
        
        if ($this->isNewRecord)
        {
            $this->oldImageFilename = null;
            if ($needUploadImageFile) {
                $this->hasImage = true;
                $this->imageExtension = $this->imageFile->extension;
            } else {
                $this->hasImage = false;
                $this->imageExtension = '';
            }
        } else {
            if ($needUploadImageFile) {
                // Загружаем новый файл. А существующий файл, если он 
                // есть, нужно удалить.
                $this->oldImageFilename = self::getImageFilenameForModel($this);
                $this->hasImage = true;
                $this->imageExtension = $this->imageFile->extension;
            } else {
                if (!$this->hasImage) { 
                    // Новый файл не загружен. А существующий файл, если он 
                    // есть, нужно удалить.
                    $this->oldImageFilename = self::getImageFilenameForModel($this);
                    $this->imageExtension = '';
                } else { 
                    // Новый фалй не загружен и старый не удаляется - ничего 
                    // менять не надо.
                    $this->oldImageFilename = null;
                }
            }
        }
        
        return true;
    }
    
    protected function afterSave() {
        // Если нужно, удалим старый файл.
        if ($this->oldImageFilename !== null) { 
            $oldFileFullFilename = self::getSaveImagesPath().'/'.$this->oldImageFilename;
            if (file_exists($oldFileFullFilename) ) {
                unlink($oldFileFullFilename);
            }
        }

        $file = UploadedFile::getInstance($this, 'imageFile');
        $needUploadImageFile = $file !== null;
        if ($needUploadImageFile) {
            $file->saveAs(self::getSaveImagesPath().'/'.$this->imageFilename);
        }  
    }
    
    public function deleteCategories() {
        CategoryNews::deleteAll(['idNews' => $this->id]);
    }
    
    public function addCategories($idCategories) {
        foreach ($idCategories as $idCategory) {
           $categoryNews = new CategoryNews();
           $categoryNews->idNew = $this->id;
           $categoryNews->idCategory =  $idCategory;
           if (!$categoryNews->save() ) {
               throw new \yii\base\Exception(); //TODO# Заменить.
           }
        }
    }
   
    public function setCategories($idCategories) {
        $this->deleteCategories();
        $this->addCategories($idCategories);
    }
    
}