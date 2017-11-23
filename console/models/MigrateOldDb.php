<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 22.11.17
 * Time: 20:06

 */

namespace console\models;

use site\entities\User\User;
use site\forms\customer\CustomerCreateForm;
use site\forms\User\UserCreateForm;
use site\repositories\CustomerRepository;
use site\repositories\UserRepository;
use site\services\customer\CustomerService;
use site\services\user\UserManageService;
use Yii;
use yii\db\Connection;


/**
 * Customer model
 *
 * @property \yii\db\Connection $db

 */

class MigrateOldDb
{
    private $db;

    public function __construct($host, $dbName, $username, $pass)
    {
        $this->connect($host, $dbName, $username, $pass);
    }

    public function connect($host, $dbName, $username, $pass): void
    {
        $this->db = new Connection([
            'dsn' => 'mysql:host='.$host.';dbname='.$dbName,
            'username' => $username,
            'password' => $pass,
            'charset' => 'utf8',
        ]);
    }

    /**
     * @param $tableName
     * @return array
     */
    public function getTableData($tableName): ?array
    {
        $query = 'SELECT * FROM '.$tableName;
        $data = $this->db->createCommand($query)->queryAll();
        return $data;
    }

    public function getBtsNiknames()
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
    }

    public function importBts()
    {
        $bts = $this->getTableData('bts');
        if(is_array($bts)){
            $userManager = new UserManageService((new UserRepository()));
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

                $newUser = $userManager->create($form);

                $nikname = new BtsNikname();
                $nikname->id = $newUser->id;
                $nikname->btsId = $btsReccord['btsId'];
                $nikname->save();
            }
            return true;
        }
    }

    public function importCustomer()
    {
        $users = $this->getTableData('users');
        if(is_array($users)){
            $customerService = new CustomerService((new CustomerRepository()));
            foreach ($users as $user){
                //var_dump(BtsNikname::getUserIdByNik($user['btsId']));
                //exit;
                $userDataArray = array(
                    'customer_name' => $user['name'],
                    'email'=> $user['email'],
                    'phone'=> $user['phone'],
                    'adress' => $user['adress'],
                    'dealer_id' => BtsNikname::getUserIdByNik($user['btsId']),
                );

                $form = new CustomerCreateForm();
                $form->attributes = $userDataArray;

                $customer = $customerService->create($form);

                $nikname = new UserNikname();
                $nikname->id = $customer->id;
                $nikname->userId = $user['userId'];
                $nikname->save();
            }
            return true;
        }
    }

}