<?php

/**
 * Standard routes. Change to what you really need.
 */
dispatch('/', 'index');

dispatch('/home', 'index'); // example

dispatch(':page', 'pages'); // dispatch all other pages to pages controller. Easy for templating.

/**
 * This should be the last route definition
 */
dispatch('/**', 'index_catchall'); 

/**
 * Function is called before every route is sent to his handler.
 */
function before_route($route) {
   
}

/**
 * Function is called before output is sent to browser.
 */
include_once('tcpdf/tcpdf.php');
include_once('fpdi/fpdi.php');

class PDF extends FPDI {
    /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx;
    
    /**
     * include a background template for every page
     */
    function Header() {
            $this->setSourceFile(dirname(__FILE__) . '/../assets/pdf/template.pdf');
        if (is_null($this->_tplIdx)) {
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx);
    }
    
    function Footer() {}
}

function after_route($output) {
  // // create new PDF document
  $pdf = new PDF();

  // // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Jeroen Bourgois');
  $pdf->SetTitle('TCPDF Example');
  $pdf->SetSubject('TCPDF Tutorial');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

  //set margins
  $pdf->SetMargins(5, 5, 5);
  $pdf->SetHeaderMargin(0);
  $pdf->SetFooterMargin(0);

  //set auto page breaks
  $pdf->SetAutoPageBreak(true, 5);

  // $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);

  // add a page
  $pdf->AddPage();
  // $pdf->writeHTML($output);

  // write text
  $pdf->SetFont('helvetica', '', 12);
  $pdf->SetTextColor(0);
  $pdf->SetXY(27, 125);
  $pdf->Cell(0, 0, "Jeroen Bourgois");
  $pdf->SetXY(62, 125);
  $pdf->Cell(0, 0, "Early Bird (EUR 55.00)");
  $pdf->SetFont('helvetica', '', 8);
  $pdf->SetXY(110, 125);
  $pdf->MultiCell(12, 0, "MULTI\nLINE", 1, 'C');
  $pdf->write2DBarcode('http://ha.ckers.org/images/slowloris.pngi', 'DATAMATRIX', 130, 119, 20, 20);

  $pdf->Output('bla.pdf', 'I');

  return $output;
}
