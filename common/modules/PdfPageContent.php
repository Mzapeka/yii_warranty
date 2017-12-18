<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.12.17
 * Time: 21:31
 */

namespace common\modules;


class PdfPageContent
{

    // настройки страници
    public $page_orientation = PDF_PAGE_ORIENTATION;
    public $unit = PDF_UNIT;
    public $page_format = PDF_PAGE_FORMAT;
    public $encoding = 'UTF-8';
    public $main_font ='freeserif';


// footer
    //todo: добавить правильный путь к логотипу
    public $logo = K_PATH_IMAGES.'logo_ua.png';
    public $title = 'Гарантійний талон №';

    //footer

    public $footer_text = "По всім питанням, повязаним з гарантійним обслуговуванням, звертайтеся в службу підтримки".
    " за телефоном 0 800 500 303. Актуальний перелік сервісних центрів Ви зможете знайти на сайті ua-ww.bosch-automotive.com";

    //общие параметры страници
    public $author = 'Automotive Solutions';
    public $title2 = 'Warranty sheet';




}