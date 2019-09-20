<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\{
    Order,
    User
};

/**
 * OrderSearch represents the model behind the search form of `common\models\Order`.
 */
class OrderSearch extends Order
{

    public function attributes()
    {
        return array_merge(parent::attributes(), ['status.name', 'user.name']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['name', 'description', 'created_at', 'status.name', 'user.name'], 'safe'],
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ((new Order())->getRole() === User::ROLE_USER)
        {
            $query->andWhere(['user_id' => \Yii::$app->user->identity->getId()]);
        }

        $query->joinWith(['status' => function($query) { $query->from(['status' => 'status']); }]);
        $query->joinWith(['user' => function($query) { $query->from(['user' => 'user']); }]);

        $dataProvider->sort->attributes['status.name'] = [
            'asc' => ['status.name' => SORT_ASC],
            'desc' => ['status.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['user.name'] = [
            'asc' => ['user.name' => SORT_ASC],
            'desc' => ['user.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['LIKE', 'status.name', $this->getAttribute('status.name')]);

        $query->andFilterWhere(['LIKE', 'user.name', $this->getAttribute('user.name')]);

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
