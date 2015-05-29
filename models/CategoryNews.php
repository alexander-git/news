<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%categorynews}}".
 *
 * @property integer $idCategory
 * @property integer $idNews
 *
 */
class CategoryNews extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%categorynews}}';
    }

    public function rules()
    {
        return [
            [['idCategory'], 'integer'],
            [['idCategory'], 
                'exist', 
                'targetClass' => Category::className(),
                'targetAttribute' => 'id',
                'message' => 'Такой категории не существует'
            ],
            
            [['idNews'], 'integer'],
            [['idNews'], 
                'exist', 
                'targetClass' => News::className(),
                'targetAttribute' => 'id',
                'message' => 'Такой новости не существует'
            ],
        ];
    }

}
