<?php
/**
 * File name    : generate.php
 * PHP Version 7.3
 * @category REZEHNDE
 * @package  Blog_as_PDF
 * @author   Marcos Rezende <rezehnde@gmail.com>
 * @license  http://opensource.org/licenses/gpl-3.0
 */


require_once "../../../wp-config.php";
require_once 'tcpdf/examples/lang/eng.php';
require_once 'tcpdf/tcpdf.php';

ob_end_clean();

// create new PDF document
$objTcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
// set document information
$objTcpdf->SetCreator(PDF_CREATOR);
$objTcpdf->SetTitle(get_option('blogname'));
// set default header data
$objTcpdf->SetHeaderData(
    null, null, get_option('blogname'), get_option('blogdescription') . "\n" . get_option('home') . "\n"
);
// set header and footer fonts
$objTcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$objTcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//set margins
$objTcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$objTcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$objTcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$objTcpdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
//set image scale factor
$objTcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$objTcpdf->setLanguageArray($l);

global $wpdb, $post;
//$query = "SELECT * FROM ".$wpdb->posts;
//$results = $wpdb->get_results($query);

$category_id = $_GET['category_id'];

$results = get_posts('numberposts=1000&category='.$category_id);

foreach ($results as $objPost) {

    $content = $objPost->post_content;
    $postOutput = preg_replace('/<img[^>]+./', '', $content);
    $pos = strpos($postOutput, '<table');
    if ($pos == true) {
        continue;
    }
    // add a page
    $objTcpdf->AddPage();

    // set font
    $objTcpdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);

    $strHtml = '<h1>' . $objPost->post_title . '</h1>' . wpautop(
        '<b>' . $objPost->post_date . '</b><br/>' . $postOutput, true
    );

    // output the HTML content
    $objTcpdf->writeHTML($strHtml, true, 0, true, 0);
}
//output PDF document
$objTcpdf->Output(get_option('blogname') . '.pdf', 'D');
?>
