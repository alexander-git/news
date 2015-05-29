<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\News;
use app\models\CategoryNews;
use yii\helpers\ArrayHelper;

/**
 * NewsSearch represents the model behind the search form about `\app\models\News`.
 */
class NewsSearch extends News
{
    public $category = null;
    
    public function rules()
    {
        return [
            [['id', 'active', 'createdAt', 'hasImage'], 'integer'],
            [['title', 'description', 'text', 'imageExtension', 'category'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return ArrayHelper::merge(['category' => 'Категория'], parent::attributeLabels() );
    }
    

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = News::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        if ($this->category !== '') {
            $db = Yii::$app->db;
            $idNews = $db->createCommand("SELECT idNews FROM ".CategoryNews::tableName()." WHERE idCategory = :idCategory")
                ->bindParam(':idCategory', $this->category)->queryColumn();
        }
        
        /*
        $query->innerJoinWith([
            'categories' => function($q)  {
                if ($this->category !== '') {
                    $q->onCondition(['idCategory' => $this->category])
                }
            }
        ]);
        */
        
        $query->with(['categories']);
        
        if ($this->category !== '') {
            $query->andFilterWhere(['id' => $idNews]);
        }
        
        $query->andFilterWhere([
            'active' => $this->active,
            'createdAt' => $this->createdAt,
            'hasImage' => $this->hasImage,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
