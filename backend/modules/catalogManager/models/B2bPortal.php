<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 19:09
 */

namespace backend\modules\catalogManager\models;



use phpQuery;
use RuntimeException;
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

class B2bPortal
{
    private $baseUrl;
    private $login;
    private $pass;

    private $cookies;
    private $client;
    private $responseLogin;

    private const MARK_COOKIE = 'BITRIX_SM_LOGIN';

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


    public function login(): bool
    {
        $data = $this->client->createRequest()
            ->setMethod('post')
            ->addHeaders(['user-agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36 OPR/38.0.2220.31'])
            ->setData([
                'backurl' => '%2F',
                'AUTH_FORM' => 'Y',
                'TYPE' => 'AUTH',
                'Login' => '%C2%EE%E9%F2%E8',
                'USER_LOGIN' => $this->login,
                'USER_PASSWORD' => $this->pass,
            ])->send();

        $this->setCookies($data->cookies);
        if(!$this->cookies->get(self::MARK_COOKIE)){
            throw new RuntimeException('Не удается подключится к удаленному каталогу');
        }

        return true;
    }

    private function setCookies(CookieCollection $cookies){
        $this->cookies = $cookies;
    }

    private function getCookies(): CookieCollection
    {
        if (!$this->cookies || !$this->cookies->get(self::MARK_COOKIE)){
            try{
                $this->login();
            }catch (RuntimeException $e){
                throw $e;
            }
        }
        return $this->cookies;
    }

    private function getPageContent(string $url = ''){
        $page = $this->client->createRequest()
            ->setMethod('post')
            ->setUrl($url)
            ->addHeaders(['user-agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36 OPR/38.0.2220.31'])
            ->setCookies($this->getCookies())
            ->send();
        return $page->content;
    }

    public function getCategories(string $catalogUrl = ''): array
    {
        $content = $this->getPageContent($catalogUrl);
        phpQuery::newDocumentHTML($content, "windows-1251");

        $categoriesArray = array();

        foreach (pq('div.open_menu') as $select){
                
             preg_match('/open_(\d+)/', pq($select)->htmlOuter(), $level);
            preg_match('/.*?SID=(\d+$)/', pq($select)->next()->children()->attr('href'), $old_id);

            $category = new B2bPortalCategory();
            $category->level = $level[1];
            $category->id = $old_id[1];
            $category->name = pq($select)->next()->children()->text();
            $categoriesArray[] = $category;

        }
        return $categoriesArray;
    }
}