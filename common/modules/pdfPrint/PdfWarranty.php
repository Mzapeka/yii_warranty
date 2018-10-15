<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.12.17
 * Time: 21:07
 */

namespace common\modules\pdfPrint;

use site\entities\Warranty\Warranty;
use TCPDF_BASE;
use Yii;

/**
 * Класс шаблона PDF страници гарантийного талона.
 * @property PdfPageContent $content
 * @property Warranty $warranty
 */

class PdfWarranty extends TCPDF_BASE
{

    private $content;
    private $warranty;

    public function __construct()
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
        $image_file = $this->content->getLogoPath();
        // Set font
        $this->SetFont($this->content->main_font, 'B', 20);
        // Title
        $this->MultiCell(0, 0, $this->content->title . ' ' . $this->warranty->id, 0, 'L', 0, 0, '15', '10', true);
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

    public function createWarrSheet(){
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
        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->device_name_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(100, 5, $this->warranty->device_name, 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->part_number_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(100, 5, $this->warranty->part_number, 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->serial_number_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(100, 5, $this->warranty->serial_number, 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->production_date_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(50, 5, $this->warranty->production_date ? Yii::$app->formatter->asDate($this->warranty->production_date, 'php:Y-m-d') : "-", 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->invoice_date_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(50, 5, Yii::$app->formatter->asDate($this->warranty->invoice_date, 'php:Y-m-d'), 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->invoice_num_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(50, 5, $this->warranty->invoice_number, 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->act_date_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(50, 5, $this->warranty->act_date ? Yii::$app->formatter->asDate($this->warranty->act_date, 'php:Y-m-d') : "-", 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->act_num_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(50, 5, $this->warranty->act_number ? $this->warranty->act_number : "-", 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->dealer_name_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(50, 5, $this->warranty->getUsers()->one()->company, 1, 'L', 0, 1, '', '', true);

        //Определение текста поля гарантии
        $warrantyText = $this->content->getWarrantyTimeAfterSales();
        If ($this->warranty->act_date)
            $warrantyText = $this->content->getWarrantyTimeAfterInstall();

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->warranty_term_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(100, 5, $warrantyText, 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 5, $this->content->warranty_end_date_title, 0, 'L', 0, 0, '', '', true);
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(100, 5, $this->warranty->warrantyValidUntil ? Yii::$app->formatter->asDate($this->warranty->warrantyValidUntil, 'php:Y-m-d') : "-", 1, 'L', 0, 1, '', '', true);

        self::instance()->SetFont($this->content->main_font_2, '', 10);
        self::instance()->MultiCell(70, 15, $this->content->sale_company_sign_title, 0, 'L', 0, 0, '', '', true, 0, false, true, 20, 'M');
        self::instance()->SetFont($this->content->main_font, '', 10);
        self::instance()->MultiCell(100, 15, '', 1, 'L', 0, 1, '', '', true);

//        self::instance()->Line(15, 139, 195, 139, $style1);
//        self::instance()->SetLineStyle($style);

        //self::instance()->Ln(125);
        self::instance()->Ln(5);
        self::instance()->setCellPaddings(0, 0, 0, 0);

// set cell margins
        self::instance()->SetFont($this->content->main_font, '', 8);
        self::instance()->setCellMargins(0, 0, 0, 0);
        self::instance()->Write(4, $this->content->getWarranty_main_condition_text(), '', 0, '', false, 0, false, false, 0);
// set color for background
        self::instance()->SetFillColor(220, 255, 220);
//        self::instance()->lastPage();

        self::instance()->Ln(10);
        // set cell padding
        self::instance()->setCellPaddings(1, 1, 1, 1);

// set cell margins
        self::instance()->setCellMargins(1, 1, 5, 1);

        self::instance()->SetFont($this->content->main_font_2, '', 9);
        self::instance()->MultiCell(70, 20,
            $this->content->buyer_agree_text,
            0, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
        self::instance()->SetFont($this->content->main_font, '', 9);
        self::instance()->MultiCell(100, 20,
            $this->content->client_sign_text,
            1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

        self::instance()->Text(165, 75, $this->content->sale_company_stamp_title);
        self::instance()->Circle(170, 80, 20, 0, 360, '', $style1);

// ---------------------------------------------------------
//Close and output PDF document
        self::instance()->Output($this->warranty->id.'_'.$this->content->output_file_name, 'D');
    }

    public function setWarranty(Warranty $warranty): void
    {
        self::instance()->warranty = $warranty;
    }
}