<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 19:09
 */

namespace backend\modules\catalogManager\models;


use phpQuery;
use site\entities\Catalog\Category;
use yii\httpclient\Client;
use yii\httpclient\Response;
use yii\web\CookieCollection;

/**
* Класс импорта каталога инструкций из внешнего сайта
* @property string $baseUrl
* @property string $login
* @property string $pass
* @property CookieCollection $cookies
* @property Client $client
* @property Response $responseLogin

*

 */

class ImportCatalog
{
    private $baseUrl;
    private $login;
    private $pass;

    private $cookies;
    private $client;
    private $responseLogin;

    public function __construct(string $url, string $login, string $pass)
    {
        $this->baseUrl = $url;
        $this->login = $login;
        $this->pass =$pass;

        $this->client = new Client([
            'baseUrl'=> $this->baseUrl,
            'transport' => 'yii\httpclient\CurlTransport'
        ]);
    }


    public function login(string $loginUrl = ''): bool
    {
        $this->responseLogin = $this->client->createRequest()
            ->setMethod('post')
            ->setUrl($loginUrl)
            ->addHeaders(['user-agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36 OPR/38.0.2220.31'])
            ->setData([
                'backurl' => '%2F',
                'AUTH_FORM' => 'Y',
                'TYPE' => 'AUTH',
                'Login' => '%C2%EE%E9%F2%E8',
                'USER_LOGIN' => $this->login,
                'USER_PASSWORD' => $this->pass,
            ])->send();

        $this->cookies = $this->responseLogin->cookies;

        if(!$this->cookies->get('BITRIX_SM_LOGIN')){
            throw new \RuntimeException('Не удается подключится к удаленному каталогу');
        }
        return true;
    }

    public function importCategories()
    {
        phpQuery::newDocumentHTML($this->responseLogin->content, "windows-1251");

        $root = Category::find()->roots()->one();

        if(!$root){
            $root = new Category([
                'name'=>'Все категории',
                'local_source' => 0,
                'description' => '',
            ]);
            $root->makeRoot();
        }

        $parent_category = array(
            1=>$root
        );

        $lastLevel = 1;
        $lastNode = null;

        foreach (pq('div.open_menu') as $select){
                
                //var_dump(iconv("windows-1251", "utf-8", pq($select)->htmlOuter()));
                preg_match('/open_(\d+)/', pq($select)->htmlOuter(), $level);
                preg_match('/.*?SID=(\d+$)/', pq($select)->next()->children()->attr('href'), $old_id);

                if($level[1] > $lastLevel){
                    $parent_category[$level[1]] = $lastNode;
                }

                $node = Category::find()->andWhere(['old_id'=>$old_id[1]])->one();

                if(!$node){
                    $node = new Category([
                        'name'=>pq($select)->next()->children()->text(),
                        'old_id' => $old_id[1],
                        'local_source' => 0,
                        'description' => '',
                    ]);
                    $node->appendTo($parent_category[$level[1]]);
                }
                $lastNode = $node;
                $lastLevel = $level[1];
        }
    }
}