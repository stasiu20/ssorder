<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Restaurants;

/**
 * RestaurantsSearch represents the model behind the search form about `app\models\Restaurants`.
 */
class RestaurantsSearch extends Restaurants
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tel_number', 'delivery_price', 'pack_price'], 'integer'],
            [['restaurantName', 'img_url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Restaurants::find();

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
            'tel_number' => $this->tel_number,
            'delivery_price' => $this->delivery_price,
            'pack_price' => $this->pack_price,
        ]);

        $query->andFilterWhere(['like', 'restaurantName', $this->restaurantName])
            
            ->andFilterWhere(['like', 'img_url', $this->img_url]);

        return $dataProvider;
    }
}
