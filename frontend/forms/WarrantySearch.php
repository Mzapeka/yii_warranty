<?php

namespace frontend\forms;

use site\entities\User\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use site\entities\Warranty\Warranty;

/**
 * WarrantySearch represents the model behind the search form of `site\entities\Warranty\Warranty`.
 */
class WarrantySearch extends Warranty
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'invoice_date', 'act_date', 'created_at', 'updated_at', 'status'], 'integer'],
            [['device_name', 'part_number', 'serial_number', 'invoice_number', 'act_number'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = User::findOne(Yii::$app->getUser()->id)->getWarranties();

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
            'customer_id' => $this->customer_id,
            'invoice_date' => $this->invoice_date,
            'act_date' => $this->act_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'device_name', $this->device_name])
            ->andFilterWhere(['like', 'part_number', $this->part_number])
            ->andFilterWhere(['like', 'serial_number', $this->serial_number])
            ->andFilterWhere(['like', 'invoice_number', $this->invoice_number])
            ->andFilterWhere(['like', 'act_number', $this->act_number]);

        return $dataProvider;
    }
}
