<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 19:09
 */

namespace backend\modules\catalogManager\models;


use phpQuery;
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

    public function getContent()
    {
        phpQuery::newDocumentHTML($this->responseLogin->content, "windows-1251");

        $parent_category = array(1=>0);
        $lastLevel = 1;
        $lastOldId = null;
        $resultArray = array();

        foreach (pq('div.open_menu') as $select){

                //var_dump(iconv("windows-1251", "utf-8", pq($select)->htmlOuter()));
                preg_match('/open_(\d+)/', pq($select)->htmlOuter(), $level);
                preg_match('/.*?SID=(\d+$)/', pq($select)->next()->children()->attr('href'), $old_id);

                if($level[1] > $lastLevel){
                    $parent_category[$level[1]] = $lastOldId;
                }

                $resultArray[] = [
                    'catName' => pq($select)->next()->children()->text(),
                    'old_id' => $old_id[1],
                    'parent_category' => $parent_category[$level[1]]
                ];

                $lastOldId = $old_id[1];
                $lastLevel = $level[1];


/*                var_dump($old_id);
                var_dump($level);
                echo "<hr/>";*/
        }
        echo "<pre>";
        var_dump($resultArray);
        echo "<pre/>";
        //var_dump(iconv("windows-1251", "utf-8", pq('.al-dl-sect-list li.lvl1:first')));
        exit;


/*        $dom = HtmlDomParser::str_get_html($this->responseLogin->content);
        $elems = $dom->find('.al-dl-sect-list>ul>li.lvl1');
        var_dump($elems->innerHtml());
        exit;
        return iconv("windows-1251", "utf-8", 'ds');*/
    }
}