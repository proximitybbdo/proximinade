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
include_once('pdfcrowd/pdfcrowd.php');
function after_route($output) {
  try {   
    // create an API client instance
    $client = new Pdfcrowd("jeroenbourgois", "31a10f47de4f3a83e03697afe9fe56ca");

    // convert a web page and store the generated PDF into a $pdf variable
    $client->usePrintMedia(true);
    $pdf = $client->convertHtml($output);

    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: no-cache");
    header("Accept-Ranges: none");
    header("Content-Disposition: attachment; filename=\"proximinade.pdf\"");

    // send the generated PDF 
    echo $pdf;
  } catch(PdfcrowdException $why) {
    echo "Pdfcrowd Error: " . $why;
  }

return $output;
}
