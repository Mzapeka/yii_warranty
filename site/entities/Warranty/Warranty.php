<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 01.10.17
 * Time: 23:02
 */

namespace site\entities\Warranty;

use DateInterval;
use DateTime;
use site\entities\Customer\Customer;
use site\entities\User\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Customer model
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $device_name
 * @property string $part_number
 * @property string $serial_number
 * @property string $invoice_number
 * @property string $act_number
 * @property integer $invoice_date
 * @property integer $act_date
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $production_date
 * @property integer $status
 *

 */

class Warranty extends ActiveRecord
{
    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 10;

    public function attributeLabels()
    {
        return self::labels();
    }

    public static function labels($name=null)
    {
        $labelsArray = array(
            'id' => 'ID гарантии',
            'customer_id' => 'Клиент',
            'device_name' => 'Название изделия',
            'part_number' => 'Артикул',
            'serial_number' => 'Серийный №',
            'invoice_number' => '№ инвойсв',
            'act_number' => '№ акта ввода в экспл.',
            'invoice_date' => 'Дата инвойса',
            'act_date' => 'Дата ввода в экспл.',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'production_date' => 'Дата производства',
            'status' => 'Статус',

            'warrantyValidUntil' => 'Дата окончания гарантии',
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
        int $customerId,
        string $deviceName,
        string $partNumber,
        string $serialNumber,
        string $invoiceNumber,
        int $invoiceDate,
        string $actNumber = null,
        int $actDate = null,
        int $status = self::STATUS_ACTIVE,
        int $productionDate = null
    ):self
    {
        $warranty = new Warranty();
        $warranty->customer_id = $customerId;
        $warranty->device_name = $deviceName;
        $warranty->part_number = $partNumber;
        $warranty->serial_number = $serialNumber;
        $warranty->invoice_number = $invoiceNumber;
        $warranty->invoice_date = $invoiceDate;
        $warranty->act_number = $actNumber;
        $warranty->act_date = $actDate;
        $warranty->status = $status;
        $warranty->production_date = $productionDate;
        return $warranty;
    }


    public function edit(
        int $customerId,
        string $deviceName,
        string $partNumber,
        string $serialNumber,
        string $invoiceNumber,
        int $invoiceDate,
        string $actNumber = null,
        int $actDate = null,
        int $status = null,
        int $productionDate = null
    ):void
    {
        $this->customer_id = $customerId;
        $this->device_name = $deviceName;
        $this->part_number = $partNumber;
        $this->serial_number = $serialNumber;
        $this->invoice_number = $invoiceNumber;
        $this->invoice_date = $invoiceDate;
        $this->act_number = $actNumber;
        $this->act_date = $actDate;
        $this->status = $status;
        $this->production_date = $productionDate;
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function setActiveStatus(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Warranty is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function setWaitStatus(): void
    {
        if ($this->isWait()) {
            throw new \DomainException('Warranty is already active.');
        }
        $this->status = self::STATUS_WAIT;
    }


    public function getCustomers(): ActiveQuery
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    public function getUsers():ActiveQuery
    {
        return $this->hasOne(User::class, ['id'=>'dealer_id'])->via('customers');
    }

    public function getWarrantyValidUntil(): int
    {

        $unixDate = max($this->invoice_date, $this->act_date);
        $interval = DateInterval::createFromDateString($this->getWarrantyLengthInMonth().' month');
        $date = new DateTime();
        $date->setTimestamp($unixDate);
        $date->add($interval);

        return $date->getTimestamp();
    }

    public function getWarrantyLengthInMonth()
    {
        return Yii::$app->params['extendedWarrantyTime']+Yii::$app->params['standardWarrantyTime'];
    }



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%warranties}}';
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