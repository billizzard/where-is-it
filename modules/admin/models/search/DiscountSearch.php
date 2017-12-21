<?php

namespace app\modules\admin\models\search;

use app\models\Category;
use app\models\Discount;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class DiscountSearch extends Discount
{

    public function rules()
    {
        return [
            [['place_id', 'type', 'status', 'created_at'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['message'], 'string', 'max' => 1000],
        ];
    }


    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Discount::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_ASC]
        ]);

        $query->andWhere(['parent_id' => 0]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'place_id' => $this->place_id,
            'status' => $this->status,
            'type' => $this->type,
        ]);

        //$query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}