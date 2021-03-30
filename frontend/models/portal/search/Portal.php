<?php

namespace frontend\models\portal\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\portal\Portal as PortalModel;
use yii\helpers\ArrayHelper;

/**
 * Portal represents the model behind the search form of `frontend\models\portal\Portal`.
 */
class Portal extends PortalModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'added_by'], 'integer'],
            [['name', 'url', 'description', 'date_added', 'logo_name'], 'safe'],
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
        $query = PortalModel::find();

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
            'added_by' => $this->added_by,
            'date_added' => $this->date_added,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'url', $this->url])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'logo_name', $this->logo_name]);

        return $dataProvider;
    }

    /**
     * Возвращает список активных порталов в виде массива
     * @return array|\frontend\models\portal\queries\Portal[]
     */
    public static function getIdAndNameList()
    {
        return static::find()
                ->active()
                ->select('id, name')
                ->asArray()
                ->all()
            ;
    }

    /**
     * @return array
     */
    public static function getIdAndNameListAsArrayMap()
    {
        $list = static::getIdAndNameList();
        return ArrayHelper::map($list,'id', 'name');
    }
}
