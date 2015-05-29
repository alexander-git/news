<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\News;
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

        $query->with(['categories']);
        
        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'createdAt' => $this->createdAt,
            'hasImage' => $this->hasImage,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'imageExtension', $this->imageExtension]);

        return $dataProvider;
    }
}
