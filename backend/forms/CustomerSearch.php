<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use site\entities\Customer\Customer;

/**
 * CustomerSearch represents the model behind the search form of `site\entities\Customer\Customer`.
 */
class CustomerSearch extends Model
{
    public $id;
    public $dealer_id;
    public $email;
    public $customer_name;
    public $adress;
    public $phone;
    public $created_at;
    public $updated_at;

    public $date_from;
    public $date_to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dealer_id', 'created_at', 'updated_at'], 'integer'],
            [['email', 'customer_name', 'adress', 'phone'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
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
        $query = Customer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'dealer_id' => $this->dealer_id,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
