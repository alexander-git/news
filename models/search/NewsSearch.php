<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\News;
use app\models\CategoryNews;
use yii\helpers\ArrayHelper;

class NewsSearch extends News
{
    public $category = '';
    
    public function rules()
    {
        return [
            [['id', 'active', 'createdAt', 'hasImage', 'category'], 'integer'],
            [['title', 'description', 'text', 'imageExtension'], 'safe'],
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
        $query->with(['categories']);
        
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        if ($this->category !== '') {
            // Нужно для того, чтобы при фильтрациии по принадлежности новостей
            // к определённой категории отобразить у найденных новостей все 
            // категории, а не только искомую.
            // На главной странице категории к которым относится новость 
            // не отображаются, поэтому там используется более простой способ.
            $db = Yii::$app->db;
            $idNews = $db->createCommand("SELECT idNews FROM ".CategoryNews::tableName()." WHERE idCategory = :idCategory")
                ->bindParam(':idCategory', $this->category)->queryColumn();
            $query->andWhere(['id' => $idNews]);
        }
        
        $query->andFilterWhere([
            'active' => $this->active,
            'hasImage' => $this->hasImage,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
