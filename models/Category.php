<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $active
 *
 * @property News[] $news
 */
class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%category}}';
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
            [['title'], 'unique', 'message' => 'Имя категории должно быть уникальным'],
            
            [['description'], 'required', 'message' => 'Описание не должно быть пустым'],
            [
                ['description'], 
                'string', 
                'min' => 1, 
                'max' => 255,
                'tooShort' => 'Описание слишком короткое',
                'tooLong' => 'Описание слишком длинное'
            ],
            
            [['active'], 'required'],
            [['active'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'active' => 'Активна',
        ];
    }


    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'idNews'])
            ->viaTable('{{%categorynews}}', ['idCategory' => 'id']);
    }        

}
