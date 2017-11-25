<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 22.11.17
 * Time: 20:06

 */

namespace app\modules\importData\models;

use app\modules\importData\forms\OldDbCredentialForm;
use site\forms\customer\CustomerCreateForm;
use site\forms\User\UserCreateForm;
use site\services\customer\CustomerService;
use site\services\user\UserManageService;
use Yii;
use yii\db\Connection;
use yii\db\Exception;
use yii\helpers\ArrayHelper;


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

    public function __construct(UserManageService $userService, CustomerService $customerService)
    {
        $this->userService = $userService;
        $this->customerService = $customerService;
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

/*    public function getBtsNiknames()
    {
        Yii::$app->db->createCommand('TRUNCATE TABLE bts_nikname')->execute();
        $bts = $this->getTableData('bts');
        if(is_array($bts)){
            foreach ($bts as $btsReccord){
                $nikname = new BtsNikname();
                $nikname->id = $btsReccord['id'];
                $nikname->btsId = $btsReccord['btsId'];
                $nikname->save();
            }
            return true;
        }
        return false;
    }

    public function getUsersNiknames()
    {
        Yii::$app->db->createCommand('TRUNCATE TABLE user_nikname')->execute();
        $users = $this->getTableData('users');
        if(is_array($users)){
            foreach ($users as $btsReccord){
                $nikname = new UserNikname();
                $nikname->id = $btsReccord['id'];
                $nikname->userId = $btsReccord['userId'];
                $nikname->save();
            }
            return true;
        }
        return false;
    }*/

    public function importBts()
    {
        try{
            $bts = $this->getTableData('bts');
        }catch (Exception $e){
            throw $e;
        }

        $countOfAddedUsers = 0;

        foreach ($bts as $btsReccord){
            $userDataArray = array(
                'username' => $btsReccord['name'],
                'email'=> $btsReccord['email'],
                'phone'=> $btsReccord['phone'],
                'password' => $btsReccord['pass'],
                'company' => $btsReccord['name'],
                'adress' => $btsReccord['adress'],
                'group' => 'dealer'
            );
            $form = new UserCreateForm();
            $form->attributes = $userDataArray;

            if($this->userService->isEmailExist($btsReccord['email'])){

                try{
                    $newUser = $this->userService->create($form);
                }catch (Exception $e){
                    Yii::$app->errorHandler->logException($e);
                    continue;
                }

                $nikname = new BtsNikname();
                $nikname->id = $newUser->id;
                $nikname->btsId = $btsReccord['btsId'];
                $nikname->save();

                $countOfAddedUsers++;
            }
        }

        return array(
            'user' => [
                'all' => count($bts),
                'added' => $countOfAddedUsers,
            ]
        );

    }

    public function importCustomer()
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

                $form = new CustomerCreateForm();
                $form->attributes = $userDataArray;

                $customer = $this->customerService->create($form);

                $nikname = new UserNikname();
                $nikname->id = $customer->id;
                $nikname->userId = $user['userId'];
                $nikname->save();
            }
            return true;
        }
    }

}