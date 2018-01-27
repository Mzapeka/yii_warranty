<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 19:09
 */

namespace common\modules\catalogManager;

use phpQuery;
use RuntimeException;
use Yii;
use yii\httpclient\Client;
use yii\web\CookieCollection;

/**
* Класс импорта каталога инструкций из внешнего сайта
* @property string $baseUrl
* @property string $login
* @property string $pass
* @property CookieCollection $cookies
* @property Client $client
* @property B2bPortalCategory $categories
* @property B2bPortalDocument $documents

*

 */

class B2bPortal
{
    private $baseUrl;
    private $login;
    private $pass;

    private $cookies;
    private $client;

    private $categories;
    private $documents;

    private const MARK_COOKIE = 'BITRIX_SM_LOGIN';
    private const URL_CATALOG = 'index_old.php';
    private const COOKIES_CACHE_TIME = 60*60*12; //в секундах

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
        if($cookies->get(self::MARK_COOKIE)){
            Yii::$app->cache->add('b2b_cookies',serialize($cookies), self::COOKIES_CACHE_TIME);
        }
        $this->cookies = $cookies;
    }

    private function getCookies(): CookieCollection
    {
        $this->cookies = unserialize(Yii::$app->cache->get('b2b_cookies'));

        if (!$this->cookies || !$this->cookies->get(self::MARK_COOKIE)){
            try{
                $this->login();
            }catch (RuntimeException $e){
                throw $e;
            }
        }
        return $this->cookies;
    }

    private function getPageContent(string $url = '', array $params = array())
    {
        $request = $this->client->createRequest()
            ->setMethod('post')
            ->setUrl($url)
            ->addHeaders(['user-agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36 OPR/38.0.2220.31'])
            ->setCookies($this->getCookies())
            ->setOptions(['followLocation' => true])
            ->prepare();

        if($params){
            $request->setData($params);
        }

        $page = $request->send();
/*        var_dump($page);
        exit;*/
        return $page->content;
    }

    public function getCategories(string $catalogUrl = self::URL_CATALOG): B2bPortalCategory
    {
        phpQuery::newDocumentHTML($this->getPageContent($catalogUrl), "windows-1251");

        $category = new B2bPortalCategory();

        foreach (pq('div.open_menu') as $select){
                
            preg_match('/open_(\d+)/', pq($select)->htmlOuter(), $level);
            preg_match('/.*?SID=(\d+$)/', pq($select)->next()->children()->attr('href'), $old_id);

            $category->setLevel($level[1]);
            $category->setId($old_id[1]);
            $category->setName(pq($select)->next()->children()->text());
            $category->add();
        }
        $this->categories = $category;
        return $category;
    }

    protected function getDocumentsByCategoryId(int $id):void
    {

        $requestParams = [
            'SID' => $id,
            'SHOWALL_1' => 1,
        ];

        phpQuery::newDocumentHTML($this->getPageContent(self::URL_CATALOG, $requestParams), "windows-1251");

        $documentList = pq('div.al-dl-docs-item');
        if($documentList->count() > 0){
            foreach ($documentList as $document){
                preg_match('/EID=(\d+)/', pq($document)->find('div.al-dl-doc-name a')->attr('href'), $docId);
                $this->documents->setId($docId[1]);
                $this->documents->setName(pq($document)->find('div.al-dl-doc-name a')->text());

                $infoSize = pq($document)->find('div.al-dl-info-size')->text();

                preg_match('#^\(([\w]{3,4}),#', $infoSize, $type);
                $this->documents->setFileType(isset($type[1])?$type[1]:'');

                preg_match('#^\([\w]{3,4},\s(.+)\)$#is', $infoSize, $size);
                $this->documents->setFileSize(isset($size[1])?$size[1]:'');

                $this->documents->setCategoryId($id);
                $this->documents->add();
            }
        }
    }

    public function getDocuments():B2bPortalDocument
    {
        $this->getCategories();
        $this->documents = new B2bPortalDocument();
        foreach ($this->categories as $category){
            $this->getDocumentsByCategoryId($category->id);
        }
        return $this->documents;
    }

    public function getDocumentContent($id)
    {
        $requestParams = [
            'EID' => $id,
        ];

        $document = $this->getPageContent(self::URL_CATALOG, $requestParams);
        return $document;
    }

}