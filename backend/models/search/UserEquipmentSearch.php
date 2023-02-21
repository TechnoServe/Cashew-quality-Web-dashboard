<?php

namespace backend\models\search;

use backend\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserEquipment;

/**
 * UserEquipmentSearch represents the model behind the search form of `backend\models\UserEquipment`.
 */
class UserEquipmentSearch extends UserEquipment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user'], 'integer'],
            [['brand', 'model', 'name', 'picture', 'manufacturing_date', 'created_at', 'updated_at', 'company_id'], 'safe'],
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
    public function search($params, $limit = 0, $paginate = true)
    {
        $query = UserEquipment::queryByCompany();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $paginate ? [] : false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_user' => $this->id_user,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'picture', $this->picture]);


        // If limit was passed
        if ($limit > 0) {
            $query->limit($limit);
        }

        return $dataProvider;
    }
}
