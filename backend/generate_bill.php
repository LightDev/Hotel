<?php

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');
require_once('../lib/tcpdf/tcpdf.php');

function remove_pl($text, $from) {
    if ($from == 'utf8') {
        $from = array(
            "\xc4\x85", "\xc4\x87", "\xc4\x99",
            "\xc5\x82", "\xc5\x84", "\xc3\xb3",
            "\xc5\x9b", "\xc5\xba", "\xc5\xbc",
            "\xc4\x84", "\xc4\x86", "\xc4\x98",
            "\xc5\x81", "\xc5\x83", "\xc3\x93",
            "\xc5\x9a", "\xc5\xb9", "\xc5\xbb",
        );
    } elseif ($from == 'latin2') {
        $from = array(
            "\xb1", "\xe6", "\xea",
            "\xb3", "\xf1", "\xf3",
            "\xb6", "\xbc", "\xbf",
            "\xa1", "\xc6", "\xca",
            "\xa3", "\xd1", "\xd3",
            "\xa6", "\xac", "\xaf",
        );
    } elseif ($from == 'cp1250') {
        $from = array(
            "\xb9", "\xe6", "\xea",
            "\xb3", "\xf1", "\xf3",
            "\x9c", "\x9f", "\xbf",
            "\xa5", "\xc6", "\xca",
            "\xa3", "\xd1", "\xd3",
            "\x8c", "\x8f", "\xaf",
        );
    }
    $clear = array(
        "\x61", "\x63", "\x65",
        "\x6c", "\x6e", "\x6f",
        "\x73", "\x7a", "\x7a",
        "\x41", "\x43", "\x45",
        "\x4c", "\x4e", "\x4f",
        "\x53", "\x5a", "\x5a",
    );
    if (is_array($text)) {
        foreach ($text as $key => $value) {
            $array[str_replace($from, $clear, $key)] = str_replace($from, $clear, $value);
        }
        return $array;
    } else {
        return str_replace($from, $clear, $text);
    }
}

//require_once('tcpdf_include.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-2', false);
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
// Set some content to print

$zapytanie = "SELECT id,numer_rezerwacji,imie, nazwisko, r.numer, to_char(od_kiedy,'dd/mm/yyyy') od, to_char(do_kiedy,'dd/mm/yyyy') do,zaplata,klucz ,
    (do_kiedy-od_kiedy)*cena  kwota,do_kiedy-od_kiedy ilosc
                          FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id)
                          WHERE (od_kiedy<=TRUNC(SYSDATE-1)) and klucz='Y' and numer_rezerwacji={$_GET['id']}
                          order by 6";

$polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
$wyrazenie = oci_parse($polaczenie, $zapytanie);
if (!oci_execute($wyrazenie)) {
    $err = oci_error($wyrazenie);
    trigger_error('Zapytanie zakoĹ?czyĹ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
}
$daneFaktury = array();
while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
    $daneFaktury["NUMER_REZERWACJI"] = $rekord['NUMER_REZERWACJI'];
    $daneFaktury["IMIE"] = remove_pl($rekord['IMIE'], 'latin2');
    $daneFaktury["NAZWISKO"] = remove_pl($rekord['NAZWISKO'], 'latin2');
    $daneFaktury["POKOJ"] = $rekord['NUMER'];
    $daneFaktury["OD"] = $rekord['OD'];
    $daneFaktury["DO"] = $rekord['DO'];
    $daneFaktury["KWOTA"] = $rekord['KWOTA'];
    $daneFaktury["ILOSC"] = $rekord['ILOSC'];
    $daneFaktury["GOSC"] = $rekord['ID'];
}
//$rowsCount = oci_num_rows($wyrazenie);
oci_close($polaczenie);

$nrKlienta = $daneFaktury['GOSC'];

$html = <<<EOD
<h1>Rachunek za usługi hotelowe nr {$daneFaktury["NUMER_REZERWACJI"]}</h1><br />
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1" >
    <tr>
        <td><b>SPRZEDAJĄCY:</b><br>
            Hotel & Restaurant<br>
                ul. Wiejska 45C, 15-234, Białystok<br>
                    NIP 456-742-3456</td>
        <td><b>NABYWCA:</b><br>
            Numer klienta: {$nrKlienta}<br>
                {$daneFaktury["IMIE"]}<br>
                {$daneFaktury["NAZWISKO"]}<br></td>
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$lp = 1;
$nrPokoju = "202";
$nazwa = "Rezerwacja pokoju nr {$daneFaktury["POKOJ"]} od {$daneFaktury["OD"]} do {$daneFaktury["DO"]}.";
$kwota = $daneFaktury["KWOTA"];
$ilosc = $daneFaktury["ILOSC"];


$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
        
   <tr >
        <td style="color:#000;background:#ccc;width:10%"><b>L.p.</b></td>
        <td style="width:60%"><b>NAZWA</b></td>
        <td style="width:10%"><b>ILOŚĆ</b></td>
        <td style="width:20%"><b>KWOTA</b></td>
    </tr>
        <tr>
        <td>{$lp}</td>
        <td>{$nazwa}</td>
        <td>{$ilosc}</td>
        <td>{$kwota} zł</td>
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$dataWystawienia = date("d-m-Y", time());
$tbl = <<<EOD
        <style>   
    div {
   margin-right:200px;     
   }
</style>
<br><p>Wystawiono dnia: {$dataWystawienia}</p>
<br><div><p class="c">........................................<br>Miejsce na pieczątke</p></div>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('bill.pdf', 'I');
