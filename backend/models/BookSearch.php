<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Book;

/**
 * BookSearch represents the model behind the search form of `backend\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['title', 'isbn', 'pageCount', 'publishedDate', 'thumbnailUrl', 'shortDescription', 'longDescription', 'authors'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Book::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'pageCount', $this->pageCount])
            ->andFilterWhere(['like', 'publishedDate', $this->publishedDate])
            ->andFilterWhere(['like', 'thumbnailUrl', $this->thumbnailUrl])
            ->andFilterWhere(['like', 'shortDescription', $this->shortDescription])
            ->andFilterWhere(['like', 'longDescription', $this->longDescription])
            ->andFilterWhere(['like', 'authors', $this->authors]);

        return $dataProvider;
    }
}
