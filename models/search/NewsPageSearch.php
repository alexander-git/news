<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\News;

class NewsPageSearch extends News
{

    public function rules()
    {
        return [
            [['id', 'active', 'createdAt', 'hasImage', 'title', 'description', 'text', 'imageExtension'], 'safe'],
        ];
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

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => true,
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
