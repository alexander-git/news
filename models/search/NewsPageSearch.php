<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\News;
use app\models\Category;


class NewsPageSearch extends Model
{
    const NEWS_PER_PAGE = 5;
    
    public $category = '';
    
    public function rules()
    {
        return [
            [['category'], 'integer'],
        ];
    }
    
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function formName() {
        return '';
    }
    
    public function search($params)
    {
        $query = News::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::NEWS_PER_PAGE,
            ],
        ]);
        
        $query->select([
            News::tableName().'.id',
            News::tableName().'.title', 
            News::tableName().'.description', 
            News::tableName().'.hasImage', 
            News::tableName().'.imageExtension', 
            News::tableName().'.createdAt'
        ]);
        
        $query->andWhere([News::tableName().'.active' => true]);
        $query->orderBy([News::tableName().'.createdAt' => SORT_DESC]);
        
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        if ($this->category !== '') { 
            $query->innerJoinWith([
                'categories' => function($q) {
                    $q->select([
                        Category::tableName().'.id',
                        Category::tableName().'.title'
                    ]);
                    $q->andOnCondition([Category::tableName().'.id' => $this->category]);
                }
            ]);
        } else {
            // Если нужно отобразить категории к которым отностится новость.
            //$query->with(['categories']);
        }
         
        return $dataProvider;
    }
    
}
