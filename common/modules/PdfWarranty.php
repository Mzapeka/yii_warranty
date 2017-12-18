<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.12.17
 * Time: 21:07
 */


namespace common\modules;

use TCPDF_BASE;
/**
 * Класс шаблона PDF страници гарантийного талона.
 * @property PdfPageContent $content
 */

class PdfWarranty extends TCPDF_BASE
{

    private $content;

    private function __construct()
    {
        $this->content = new PdfPageContent();
        parent::__construct(
            $this->content->page_orientation,
            $this->content->unit,
            $this->content->page_format,
            true,
            $this->content->encoding,
            false,
            false
        );
    }

    //Page header
    public function Header() {
        // Logo
        $image_file = $this->content->logo;
        // Set font
        $this->SetFont($this->content->main_font, 'B', 20);
        // Title
        $this->MultiCell(0, 0, $this->content->title, 0, 'L', 0, 0, '15', '10', true);
        $this->Image($image_file, 3, 4, 40, '', 'PNG', '', 'T', false, 300, 'R', false, false, 0, false, false, false);
        $style1 = array('width' => 0.8, 'cap' => 'butt', 'join' => 'miter', 'dash' => '0', 'phase' => 10, 'color' => array(0, 0, 0));
        $this->Line(15, 25, 195, 25, $style1);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $text = $this->content->footer_text;
        $this->SetFont($this->content->main_font, 'I', 10);
        // Page number
        $this->MultiCell(180, 15, $text, 0, 'C', 0, 1, '', '', true, 0, false, true, 60, 'T', true);
    }

    static function instance(){
        static $pdf;
        if (!$pdf){
            $pdf = new self();
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($pdf->content->author);
            $pdf->SetTitle($pdf->content->title2);
            $pdf->SetSubject('');
            $pdf->SetKeywords('');
// set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 005', PDF_HEADER_STRING);
// set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
            $l = Array();

// PAGE META DESCRIPTORS --------------------------------------

            $l['a_meta_charset'] = 'UTF-8';
            $l['a_meta_dir'] = 'ltr';
            $l['a_meta_language'] = 'ua';

// TRANSLATIONS --------------------------------------
            $l['w_page'] = 'сторінка';

            $pdf->setLanguageArray($l);
        }
        return $pdf;
    }

    public function createWarrSheet($warrSheet = array()){
        self::instance()->AddPage();

// set cell padding
        self::instance()->setCellPaddings(1, 1, 1, 1);

// set cell margins
        self::instance()->setCellMargins(1, 1, 5, 1);

// set color for background
        self::instance()->SetFillColor(255, 255, 127);

//установим стиль линии разделителя
        $style1 = array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => '0', 'phase' => 10, 'color' => array(0, 0, 0));
        $style = array('width' => 0.3, 'cap' => 'round', 'join' => 'miter', 'dash' => '0', 'phase' => 0, 'color' => array(0, 0, 0));


// Multicell test
        self::instance()->Ln(2);
        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 5, 'Найменування виробу', 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(100, 5, $warrSheet['devName'], 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 5, 'Артикул', 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(100, 5, $warrSheet['pn'], 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 5, 'Серійний номер', 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(100, 5, $warrSheet['serialN'], 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 5, 'Дата продажу', 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(50, 5, $warrSheet['invoiceDate'], 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 5, 'Номер накладної', 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(50, 5, $warrSheet['invoiceN'], 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 5, 'Дата введення в эксплуатацію', 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(50, 5, $warrSheet['actDate']!="0000-00-00"?$warrSheet['actDate']:"-", 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 5, 'Номер акту введення в експлуатацію', 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(50, 5, $warrSheet['actN']?$warrSheet['actN']:"-", 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 5, 'Компанія-продавець', 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(50, 5, $warrSheet['dealerName'], 1, 'L', 0, 1, '', '', true);

        //Определение текста поля гарантии
        $warrantyText = "24 місяці від дати продажу";
        If ($warrSheet['actN'] != "" & $warrSheet['actDate'] != "0000-00-00")
            $warrantyText = "24 місяці від дати введення в експлуатацію";

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 5, 'Термін гарантії', 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(100, 5, $warrantyText, 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 20, 'Підпис та П.І.Б. продавця', 0, 'L', 0, 0, '', '', true, 0, false, true, 20, 'M');
        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(100, 20, $warrSheet['invDate'], 1, 'L', 0, 1, '', '', true);

        self::instance()->Text(165, 70, 'М.П.');
        self::instance()->Circle(170, 75, 20, 0, 360, '', $style1);
//Mypdf::instance()->Text(15, 115, 'Власник обладнання');
        self::instance()->Line(15, 130, 195, 130, $style1);
        self::instance()->SetLineStyle($style);
//вставляем номер гарантийного талона
        self::instance()->SetFont('freeserif', '', 16);
        self::instance()->Text(100, 9, $warrSheet['id'] + SHIFTID);

        self::instance()->Ln(125);

        self::instance()->SetFont('freeserifb', '', 10);
        self::instance()->MultiCell(70, 20,
            'Виріб належної якості, укомплектований, технічно справний, претензій не маю. '.
            'З умовами гарантії ознайомлений',
            0, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');

        self::instance()->SetFont('freeserif', '', 10);
        self::instance()->MultiCell(100, 20,
            'П.І.Б та підпис покупця',
            1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

        self::instance()->Ln(5);

        //Mypdf::instance()->setFontSubsetting(true);
        self::instance()->setCellPaddings(0, 0, 0, 0);

// set cell margins
        self::instance()->setCellMargins(0, 0, 0, 0);
        //echo dirname(__FILE__).'/templates/conditions.txt';
        $utf8text = file_get_contents(dirname(__FILE__).'/templates/conditions.txt', false);
        //echo $utf8text;
        self::instance()->Write(5, $utf8text, '', 0, '', false, 0, false, false, 0);
// set color for background
        self::instance()->SetFillColor(220, 255, 220);

        self::instance()->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
        self::instance()->Output('example_005.pdf', 'I');

    }
}