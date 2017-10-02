<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 01.10.17
 * Time: 23:02
 */

namespace site\entities\Warranty;
use site\repositories\WarrantyRepository;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
 * @property integer $status
 *

 */

class Warranty extends ActiveRecord
{
    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 10;

    public static function create(
        int $customerId,
        string $deviceName,
        string $partNumber,
        string $serialNumber,
        string $invoiceNumber,
        int $invoiceDate,
        string $actNumber = null,
        int $actDate = null
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
        $warranty->status = self::STATUS_ACTIVE;
        //$warranty->created_at = time();
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
        int $actDate = null
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