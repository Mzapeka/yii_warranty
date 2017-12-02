<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 22.11.17
 * Time: 20:06

 */

namespace app\modules\importData\models;

use app\modules\importData\forms\OldDbCredentialForm;
use site\entities\Warranty\Warranty;
use site\forms\customer\CustomerCreateForm;
use site\forms\User\UserCreateForm;
use site\forms\warranty\WarrantyCreateForm;
use site\services\customer\CustomerService;
use site\services\user\UserManageService;
use site\services\warranty\WarrantyService;
use Yii;
use yii\db\Connection;
use yii\db\Exception;


/**
 * Customer model
 *
 * @property \yii\db\Connection $db

 */

class MigrateOldDb
{
    private $db;

    private $userService;
    private $customerService;
    private $warrantyService;

    public function __construct(
        UserManageService $userService,
        CustomerService $customerService,
        WarrantyService $warrantyService
    )
    {
        $this->userService = $userService;
        $this->customerService = $customerService;
        $this->warrantyService = $warrantyService;
    }

    public function connect(OldDbCredentialForm $credentialForm): void
    {
        $this->db = new Connection([
            'dsn' => 'mysql:host='.$credentialForm->path.';dbname='.$credentialForm->dbName,
            'username' => $credentialForm->userName,
            'password' => $credentialForm->pass,
            'charset' => 'utf8',
        ]);

        $this->db->open();
    }

    public function importDataBase():array
    {
        $result =[];
        try{
            $result['user'] = $this->importUsers();
            $result['customer'] = $this->importCustomer();
            $result['warranty'] = $this->importWarranties();
        }catch (Exception $e){
            throw $e;
        }
        return $result;
    }


    /**
     * @param $tableName
     * @return array
     */
    public function getTableData($tableName): ?array
    {

        $query = 'SELECT * FROM '.$tableName;
        try{
            $data = $this->db->createCommand($query)->queryAll();
        }catch(Exception $e){
            throw $e;
        }

        return $data;
    }


    private function importUsers():array
    {
        try{
            $bts = $this->getTableData('bts');
        }catch (Exception $e){
            throw $e;
        }

        $countOfAddedUsers = 0;

        foreach ($bts as $btsRecord){
            $userDataArray = array(
                'username' => $btsRecord['name'],
                'email'=> $btsRecord['email'],
                'phone'=> $btsRecord['phone'],
                'password' => $btsRecord['pass'],
                'company' => $btsRecord['name'],
                'adress' => $btsRecord['adress'],
                'group' => 'dealer'
            );

            if(!$this->userService->isEmailExist($btsRecord['email'])){
                $form = new UserCreateForm();
                $form->attributes = $userDataArray;

                try{
                    $newUser = $this->userService->create($form);
                }catch (Exception $e){
                    Yii::$app->errorHandler->logException($e);
                    continue;
                }

                $nikname = new BtsNikname();
                $nikname->id = $newUser->id;
                $nikname->btsId = $btsRecord['btsId'];
                $nikname->save();

                $countOfAddedUsers++;
            }
        }

        return array(
                'all' => count($bts),
                'added' => $countOfAddedUsers
        );

    }

    private function importCustomer():array
    {
        try{
            $users = $this->getTableData('users');
        }catch (Exception $e){
            throw $e;
        }

        $countOfAddedCustomers = 0;

        if(is_array($users)){
            foreach ($users as $user){
                $userDataArray = array(
                    'customer_name' => $user['name'],
                    'email'=> $user['email'],
                    'phone'=> $user['phone'],
                    'adress' => $user['adress'],
                    'dealer_id' => BtsNikname::getUserIdByNik($user['btsId']),
                );

                if(!UserNikname::isCustomerExist($user['userId'])){
                    $form = new CustomerCreateForm();
                    $form->attributes = $userDataArray;

                    try{
                        $customer = $this->customerService->create($form);
                    }catch (Exception $e){
                        Yii::$app->errorHandler->logException($e);
                        continue;
                    }

                    $nikname = new UserNikname();
                    $nikname->id = $customer->id;
                    $nikname->userId = $user['userId'];
                    $nikname->save();

                    $countOfAddedCustomers++;
                }
            }
        }
        return array(
                'all' => count($users),
                'added' => $countOfAddedCustomers
        );
    }

    private function importWarranties():array
    {
        try{
            $warranties = $this->getTableData('warBase');
        }catch (Exception $e){
            throw $e;
        }
        $countOfAddedWarranties = 0;
        if(is_array($warranties)){
            foreach ($warranties as $warranty){
                $warrantyDataArray = array(
                    'device_name' => $warranty['devName'],
                    'part_number'=> $warranty['pn'],
                    'serial_number'=> $warranty['serialN'],
                    'invoice_number' => $warranty['invoiceN'],
                    'act_number' => $warranty['actN'],
                    'invoice_date' => strtotime($warranty['invoiceDate']),
                    'act_date' => ($warranty['actDate'] == '0000-00-00') ? null : strtotime($warranty['actDate']),
                    'customer_id' => UserNikname::getCustomerIdByNik($warranty['idUser']),
                    'status' => Warranty::STATUS_ACTIVE,
                );

                if(!WarrantyRegister::findOne(['oldId' => $warranty['id']])){
                    $form = new WarrantyCreateForm();
                    $form->attributes = $warrantyDataArray;

                    try{
                        $this->warrantyService->create($form);
                    }catch (Exception $e){
                        Yii::$app->errorHandler->logException($e);
                        continue;
                    }

                    $oldIdRecord = new WarrantyRegister();
                    $oldIdRecord->oldId = $warranty['id'];
                    $oldIdRecord->save();

                    $countOfAddedWarranties++;
                }
            }
        }
        return array(
                'all' => count($warranties),
                'added' => $countOfAddedWarranties
        );
    }

}