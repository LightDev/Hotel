<?php

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');
require_once('../lib/tcpdf/tcpdf.php');

//require_once('tcpdf_include.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('id obslugi');
//$pdf->SetTitle('Rachunek nr 00003');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, 30);
$pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));

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
//$pdf->setImageScale(5);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

$zm = "tekst";
// Set some content to print
$nr = 2;
$nrKlienta = 1;
$imie = "Pawe³";
$nazwisko = "Parafiniuk";

$html = <<<EOD
<h1 class="">Rachunek za us³ugi hotelowe nr {$nr}</h1>
        <p>Dane osobowe:</p>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td><b>SPRZEDAJ¡CY:</b><br>
            Hotel & Restaurant<br>
                ul. Wiejska 45C, 15-234, Bia³ystok<br>
                    NIP 456-742-3456</td>
        <td><b>NABYWCA:</b><br>
            Numer klienta: {$nrKlienta}<br>
                {$imie}<br>
                {$nazwisko}<br></td>
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$lp = 1;
$nrPokoju = "202";
$nazwa = "rezerwacja pokoju nr {$nrPokoju}";
$kwota = 500;


$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
        
   <tr >
        <td style="color:#000;background:#ccc"><b>L.p.</b></td>
        <td><b>NAZWA</b></td>
        <td><b>KWOTA</b></td>
    </tr>
        <tr>
        <td>{$lp}</td>
        <td>{$nazwa}</td>
        <td>{$kwota}</td>
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$dataWystawienia = date("d-m-Y", time());
$tbl = <<<EOD
<br><p>Wystawiono dnia: {$dataWystawienia}</p>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');


// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('bill.pdf', 'I');