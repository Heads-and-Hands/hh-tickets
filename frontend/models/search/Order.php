<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Order as OrderModel;

/**
 * Order represents the model behind the search form of `frontend\models\Order`.
 */
class Order extends OrderModel
{
    public $statusName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['status_id'], 'string'],
            [['name', 'description', 'created_at', 'statusName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = OrderModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'order.id',
                'order.name',
                'description',
                'statusName' => [
                    'asc' => ['status.name' => SORT_ASC],
                    'desc' => ['status.name' => SORT_DESC],
                    'label' => 'Статус'
                ],
                'created_at',
            ]
        ]);

        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['status']);
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'name', true);
        $this->addCondition($query, 'description', true);
        $this->addCondition($query, 'status_id');
        $this->addCondition($query, 'created_at');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'order.id' => $this->id,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'order.name', $this->name])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        $query->joinWith(['status' => function ($q) {
            $q->andFilterWhere(['like', 'status.name', $this->statusName]);
        }]);

        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        $value = $this->$modelAttribute;
        if (trim($value) === '') {
            return;
        }

        $attribute = "order.$attribute";

        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
