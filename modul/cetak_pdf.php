<?php

ob_end_clean();
include "../fungsi.php";

// require_once 'library/tcpdf.php';
require_once '../assets/plugins/vendor/tecnickcom/tcpdf/tcpdf.php';
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8, false');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Tally Sheet Vessel");
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setHeaderFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(15, 15, 15);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->setAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->SetFont('helvetica', '', 11);
$pdf->AddPage();
$style = array('width' => 0.7, 'dash' => '0, 0, 0, 0', 'phase' => 0);
$pdf->Line(5, 30, 290, 30, $style);

$isi = "<p align='center' style='width: 520px;'><font style='font-size: 18px'><b>MONITORING SERVER</b></font></p>
        <table border='2' >
            <tr>  
              <th style='width: 60px;'>Kode Server</th>
              <th style='width: 500px;'> : SRV001</th>
              <th style='width: 63px;'>Kategori Server</th>
              <th> : Server File</th>
            </tr>
            <tr>  
              <th>Nama Unit</th>
              <th> : Server HW</th>
              <th>PIC</th>
              <th> : Agus Choi</th>
            </tr>
            <tr>  
              <th>IP/Domain</th>
              <th> : Ekanuri.com</th>
              <th>Selesai Kegiatan</th>
              <th> : test</th>
            </tr>
            <tr>  
              <th>Durasi Kegiatan</th>
              <th> : test</th>
            </tr>
          </table><br>
";

$pdf->writeHTML($isi);
$pdf->Output('TallySheetVessel-' . $idJoborder . '.pdf', 'I');
