<?php

namespace app\modules\admin\models\search;

use app\models\Category;
use app\models\Contact;
use app\models\Discount;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class ContactSearch extends Contact
{


    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Contact::find();

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
        ]);

        //$query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}