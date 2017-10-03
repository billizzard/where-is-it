<?php

namespace app\modules\admin\models\search;

use app\models\Category;
use app\models\City;
use app\models\Place;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * CitySearch represents the model behind the search form about `app\models\City`.
 */
class PlaceSearch extends Place
{

    public function rules()
    {
        return [
            [['lat', 'lon', 'category_id', 'status'], 'number'],
            [['name', 'address'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }


    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Place::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_ASC]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}