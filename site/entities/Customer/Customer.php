<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 01.10.17
 * Time: 22:30
 */

namespace site\entities\Customer;
use site\entities\User\User;
use site\entities\Warranty\Warranty;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Customer model
 *
 * @property integer $id
 * @property integer $dealer_id
 * @property string $email
 * @property string $customer_name
 * @property string $adress
 * @property string $phone
 * @property integer $created_at
 * @property integer $updated_at
 *

 */

class Customer extends ActiveRecord
{
    public function attributeLabels()
    {
        return self::labels();
    }

    public static function labels($name=null)
    {
        $labelsArray = array(
            'id' => 'ID клиента',
            'dealer_id' => 'Дилер',
            'email' => 'E-mail',
            'customer_name' => 'Имя клиента',
            'adress' => 'Адрес',
            'phone' => 'Телефон',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        );
        if(!is_null($name)){
            if(ArrayHelper::keyExists($name, $labelsArray)){
                return $labelsArray[$name];
            }
            return null;
        }
        return $labelsArray;
    }


    public static function create(
        int $dealer_id,
        string $email,
        string $customer_name,
        string $adress = null,
        string $phone = null
    ):self
    {
        $customer = new Customer();
        $customer->dealer_id = $dealer_id;
        $customer->email = $email;
        $customer->customer_name = $customer_name;
        $customer->adress = $adress;
        $customer->phone = $phone;
        return $customer;
    }


    public function edit(
        int $dealer_id,
        string $email,
        string $customer_name,
        string $adress,
        string $phone
    ):void
    {
        $this->dealer_id = $dealer_id;
        $this->email = $email;
        $this->customer_name = $customer_name;
        $this->adress = $adress;
        $this->phone = $phone;
    }


    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'dealer_id']);
    }

    public function getWarranty():ActiveQuery
    {
        return $this->hasMany(Warranty::class, ['customer_id'=>'id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customers}}';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

}