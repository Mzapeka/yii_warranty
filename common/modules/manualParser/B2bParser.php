<?php

/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 05.08.16
 * Time: 20:27
 */
namespace System;

use simple_html_dom;

include_once ("simple_html_dom.php");

class B2bParser
{
    public $url; // URL сайта
    private $curl; // тут хранится объект CURL
    // параметры user agent для CURL
    public $userAgent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36 OPR/38.0.2220.31";
    public $cookiesPath; // путь к файлу cookies
    public $login; // логин к сайту
    public $pass; // пароль к сайту
    public $catalogFilePath; // путь к файлу с массивом элементов каталога

    public $htmlAfterLogin; //хтмл страница, полученная после залогинивания
    private $isLogin = false; // если залогинились = тру
    public $errorMessage; // свойство, содержащее ошибку с последнего действия

    public $categories; //массив категорий каталога
    public $catalog; //массив структуры каталога
    public $timeForUpdate = 86400; //время от момента создания файла, после которого нужно файл обновить

    function __construct($url = false, $cookies = false, $login = false, $pass = false)
    {
        $this->curl = curl_init();
        $this->cookiesPath = $cookies;
        $this->login = $login;
        $this->pass = $pass;
        $this->url = $url;
    }

    /**
     * @return bool|string
     */
    //метод для залогинивания на сайте
    public function login()
    {
        if (is_null($this->url)) {
            $this->errorMessage = "URL not setup";
            return false;
        }

        if (is_null($this->cookiesPath)) {
            $this->errorMessage = "Please, set up the cookies path";
            return false;
        }

        if (strtolower((substr($this->url, 0, 5)) == 'https')) { // если соединяемся с https
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        }
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
        // откуда пришли на эту страницу
        curl_setopt($this->curl, CURLOPT_REFERER, $this->url);
        // cURL будет выводить подробные сообщения о всех производимых действиях
        curl_setopt($this->curl, CURLOPT_VERBOSE, 0);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
        //устанавливаем данные ПОСТ
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, "backurl=%2F&AUTH_FORM=Y&TYPE=AUTH&USER_LOGIN=" . $this->login . "&USER_PASSWORD=" . $this->pass . "&Login=%C2%EE%E9%F2%E8");
        curl_setopt($this->curl, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        //сохранять poluченные COOKIE в файл
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookiesPath);
        $result = curl_exec($this->curl);

        // Убеждаемся что произошло залогинивание после авторизации по отсутствию дива с классом формы логина
                if(!(strpos($result,'<div class="bx-system-auth-form">')===false)) {
                    $this->isLogin = false;
                    $this->errorMessage = 'Login incorrect';
                    return false;
                }
        $this->isLogin = true;
        $this->errorMessage = '';
        //конвертируем страничку в ЮТФ-8 и сохраняем в свойстве htmlAfterLogin
        $this->htmlAfterLogin = iconv("windows-1251", "utf-8", $result);
        //die($this->htmlAfterLogin);
        return true;
    }

// парсим категории каталога
    public function readCategories()
    {
        if (!$this->isLogin) {
            $this->login();
        }
        //проверяем наличие библиотеки simple_html_dom
        if (!is_callable("file_get_html")) {
            $this->errorMessage = "Подключите библиотеку simple_html_dom";
            return false;
        }
        $html = new simple_html_dom();
        $html->load($this->htmlAfterLogin);
        foreach ($html->find('li.lvl2 div.al-dl-link-area a') as $it) {
            $data[] = array('href' => $it->href, 'text' => $it->innertext);
        }
        $this->categories = $data;
        $html->clear();
        unset($html);
        return true;
    }
    // возвращаем массив с каталогом
    function getCatalogArray()
    {
        if (file_exists($this->catalogFilePath)) {
            $delta = time() - filemtime($this->catalogFilePath);
            //проверка на возраст файла, если файл свежий - читаем из него. Если нет - обновляем
            if ($delta < $this->timeForUpdate) {
                return unserialize(file_get_contents($this->catalogFilePath));
            }
            $this->getCatalog();
            return $this->catalog;
        }
        $this->errorMessage = "Файл с каталогом не найден";
        $this->getCatalog();
        return $this->catalog;
    }
// получаем каталог с сайта используя свойство с массивом каталога
    private function getCatalog()
    {
        if (!is_array($this->categories)) {
            $this->readCategories();
        }
        //проверяем наличие библиотеки simple_html_dom
        if (!is_callable("file_get_html")) {
            $this->errorMessage = "Подключите библиотеку simple_html_dom";
            return false;
        }
        foreach ($this->categories as $category) {
            $result = $this->readItemsInCategory($category['href']);
            $html = new simple_html_dom($result);
            foreach ($html->find('div.al-dl-docs-list div.al-dl-docs-item') as $link) {
                foreach ($link->find('div.al-dl-doc-name a') as $s) {
                    //ссылка на файл в каталоге
                    $href = $s->href;
                    //название файла
                    $name = $s->innertext;
                };
                //получаем данные размера и типа файла
                foreach ($link->find('div.al-dl-doc-info div.al-dl-info-size') as $data)
                    $size = $data->innertext;
                $size = explode(", ", preg_replace('/(\(|\))/', '', $size));
                //ссоставляем массив с файлами в категории
                $manuals[] = array('href' => $href, 'name' => $name, 'type' => $size[0], 'size' => $size[1]);
            }
            //создаем массив с категориями и их элементами
            $array[] = array(
                'href' => $category['href'],
                'text' => $category['text'],
                'items' => $manuals
            );
            $html->clear();
            unset($html);
            unset($manuals);
        }
        $this->catalog = $array;
        //пишем массив в файл
        file_put_contents($this->catalogFilePath, serialize($this->catalog));
        return true;
    }
//получаем файл по запрошенной ссылке
    public function getFile($idFile)
    {
        if (!$this->isLogin) {
            $this->login();
        }
        $url = $this->url . $idFile;
        curl_setopt($this->curl, CURLOPT_URL, $url);
        // откуда пришли на эту страницу
        //curl_setopt($ch, CURLOPT_REFERER, $url);
        //запрещаем делать запрос с помощью POST и соответственно разрешаем с помощью GET
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_FAILONERROR, 0);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 15);
        //отсылаем  COOKIE полученные от него при авторизации
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookiesPath);
        curl_setopt($this->curl, CURLOPT_USERAGENT, $this->userAgent);

        $result = curl_exec($this->curl);
        //возвращаем содержимое файла
        //требует специального вывод
        //header ("Content-type: application/".$type, false );
        //header('Content-Disposition: inline; filename=manual.'.$type, false);

        return $result;
    }
    //считываем ссылки на файлы из категории
    private function readItemsInCategory($category)
    {
        if (!$this->isLogin) {
            $this->login();
        }
        if (!is_callable("file_get_html")) {
            $this->errorMessage = "Подключите библиотеку simple_html_dom";
            return false;
        }
        $url = $this->url . $category . "&SHOWALL_1=1";
        curl_setopt($this->curl, CURLOPT_URL, $url);
        // откуда пришли на эту страницу
        //curl_setopt($ch, CURLOPT_REFERER, $url);
        //запрещаем делать запрос с помощью POST и соответственно разрешаем с помощью GET
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_FAILONERROR, 0);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 15);
        //отсылаем  COOKIE полученные от него при авторизации
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookiesPath);
        curl_setopt($this->curl, CURLOPT_USERAGENT, $this->userAgent);

        return iconv("windows-1251", "utf-8", curl_exec($this->curl));
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }
} 