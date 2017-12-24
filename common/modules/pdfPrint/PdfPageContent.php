<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.12.17
 * Time: 21:31
 */

namespace common\modules\pdfPrint;


use Yii;

class PdfPageContent
{

    // настройки страници
    public $page_orientation = PDF_PAGE_ORIENTATION;
    public $unit = PDF_UNIT;
    public $page_format = PDF_PAGE_FORMAT;
    public $encoding = 'UTF-8';
    public $main_font ='freeserif';
    public $main_font_2 ='freeserifb';




// footer

    public $title = 'Гарантійний талон №';

    //footer

    public $footer_text = "По всім питанням, повязаним з гарантійним обслуговуванням, звертайтеся в службу підтримки".
    " за телефоном 0 800 500 303. Актуальний перелік сервісних центрів Ви зможете знайти на сайті ua-ww.bosch-automotive.com";

    //общие параметры страници
    public $author = 'Automotive Solutions';
    public $title2 = 'Warranty sheet';
    public $device_name_title = 'Найменування виробу';
    public $part_number_title = 'Артикул';
    public $serial_number_title = 'Серійний номер';
    public $invoice_date_title = 'Дата продажу';
    public $invoice_num_title = 'Номер накладної';
    public $act_date_title = 'Дата введення в эксплуатацію';
    public $act_num_title = 'Номер акту введення в експлуатацію';
    public $dealer_name_title = 'Компанія-продавець';
    public $warranty_term_title = 'Термін гарантії';
    public $sale_company_sign_title = 'Підпис та П.І.Б. продавця';
    public $sale_company_stamp_title = 'М.П.';
    //public $warranty_main_condition_text = '';
    public $output_file_name = 'warranty.pdf';
    public $client_sign_text = 'П.І.Б та підпис покупця';
    public $buyer_agree_text = 'Виріб належної якості, укомплектований, технічно справний, претензій не маю. '.
                                'З умовами гарантії ознайомлений';


    public function getWarranty_main_condition_text(){
        return file_get_contents(Yii::getAlias('@common/modules/pdfPrint/conditions.txt'));
    }

    public function getWarrantyTimeAfterSales(){
        return "24 місяці від дати продажу";
    }

    public function getWarrantyTimeAfterInstall(){
        return "24 місяці від дати введення в експлуатацію";
    }

    public function getLogoPath(){
        return Yii::getAlias('@web/img/').'logo_ua.png';
    }




}