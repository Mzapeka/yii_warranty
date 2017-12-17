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
                    'act_date',
                    'invoice_date',
                ], 'string'
            ],
            [
                [
                    'warrantyValidUntil',
                ],'safe'
            ],
            [
                [
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

        $actDateRange = self::getDateRange($this->act_date);
        $invoiceDateRange = self::getDateRange($this->invoice_date);
/*        var_dump($actDateRange);
        exit;*/

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
            ->andFilterWhere(['>=', 'act_date', $actDateRange[0] ? strtotime($actDateRange[0] . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'act_date', $actDateRange[1] ? strtotime($actDateRange[1] . ' 23:59:59') : null])
            ->andFilterWhere(['>=', 'invoice_date', $invoiceDateRange[0] ? strtotime($invoiceDateRange[0] . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'invoice_date', $invoiceDateRange[1] ? strtotime($invoiceDateRange[1] . ' 23:59:59') : null]);


        return $dataProvider;
    }

    private static function getDateRange($dateRange){
        $dateRangeArray = explode(' - ', $dateRange);
        if(count($dateRangeArray) == 2){
            return $dateRangeArray;
        }
        return array('', '');
    }
}
