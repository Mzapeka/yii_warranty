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

    public $warrantyValidUntil;
    public $act_date_to;
    public $invoice_date_to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'status'], 'integer'],
            [
                [
                'device_name',
                'part_number',
                'serial_number',
                'invoice_number',
                'act_number',
                ], 'string'
            ],
            [
                [
                    'warrantyValidUntil',
                    'act_date_to',
                    'invoice_date_to'
                ],'safe'
            ],
            [
                [
                    'invoice_date',
                    'act_date',
                    'created_at',
                    'updated_at'
                ], 'date', 'format' => 'php:Y-m-d'
            ]
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
        //var_dump($this->act_date);
        //exit;
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'device_name', $this->device_name])
            ->andFilterWhere(['like', 'part_number', $this->part_number])
            ->andFilterWhere(['like', 'serial_number', $this->serial_number])
            ->andFilterWhere(['like', 'invoice_number', $this->invoice_number])
            ->andFilterWhere(['like', 'act_number', $this->act_number])
            ->andFilterWhere(['>=', 'act_date', $this->act_date ? strtotime($this->act_date . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'act_date', $this->act_date_to ? strtotime($this->act_date_to . ' 23:59:59') : null])
            ->andFilterWhere(['>=', 'invoice_date', $this->invoice_date ? strtotime($this->invoice_date . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'invoice_date', $this->invoice_date_to ? strtotime($this->invoice_date_to . ' 23:59:59') : null]);


        return $dataProvider;
    }
}
