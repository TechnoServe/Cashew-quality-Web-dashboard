<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Qar;

/**
 * QarSearch represents the model behind the search form of `backend\models\Qar`.
 */
class QarSearch extends Qar
{

    public $created_at_start;
    public $created_at_end;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'buyer', 'field_tech', 'farmer', 'initiator', 'site'], 'integer'],
            [['audit_quantity', 'created_at', 'updated_at', 'created_at_start', 'created_at_end', 'status'], 'safe'],
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
        $query = Qar::queryByCompany();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $paginate ? [] : false,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'buyer' => $this->buyer,
            'field_tech' => $this->field_tech,
            'farmer' => $this->farmer,
            'initiator' => $this->initiator,
            'site' => $this->site,
            'company_id' => $this->company_id,
            'status' => $this->status,
        ]);


        if ($this->created_at_start) {
            $query->andWhere([
                '>=',
                'created_at',
                date("Y/m/d H:i:s",
                    strtotime($this->created_at_start." 00:00:00")),
            ]);
        }


        if ($this->created_at_end) {
            $query->andWhere([
                '<=',
                'created_at',
                date("Y/m/d H:i:s", strtotime($this->created_at_end." 23:59:59")),
            ]);
        }

        // If limit was passed
        if ($limit > 0) {
            $query->limit($limit);
        }

        return $dataProvider;
    }
}
