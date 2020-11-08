<?php

namespace frontend\models\portal\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\portal\Account as AccountModel;

/**
 * Account represents the model behind the search form of `frontend\models\portal\Account`.
 */
class Account extends AccountModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'portal_id', 'status', 'added_by'], 'integer'],
            [['username', 'password', 'description', 'date_added'], 'safe'],
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
        $query = AccountModel::find();

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
            'portal_id' => $this->portal_id,
            'date_added' => $this->date_added,
            'status' => $this->status,
            'added_by' => $this->added_by,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'password', $this->password])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
