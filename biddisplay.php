<?php
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// Get the xsl and return it to the js to display on the htm page 

$xmlDoc = new DomDocument;
$xmlDoc->load("../../data/auction.xml");
$xslDoc = new DomDocument;
$xslDoc->load("bidding.xsl");
$proc = new XSLTProcessor;
$proc->registerPHPFunctions();
$proc->importStyleSheet($xslDoc);
echo $proc->transformToXML($xmlDoc);

function timeLeft($inum) {
    $xml = simplexml_load_file("../../data/auction.xml");
    $items = $xml->children();

    foreach($items as $item) {
        if ($item->inum == $inum) {
            $theIt = $item;
        }
    }

    $start = date_create( "$theIt->sd $theIt->st");
    $dur = date_interval_create_from_date_string($theIt->durd.'days + '.$theIt->durh.'hours + '. $theIt->durm.'minutes');
    $end = date_add($start, $dur);
    $now = new DateTime();
    $rem = date_diff($now, $end); // false
    //echo $rem;
    return $rem->format('%d days %h hours %i minutes %s seconds remaining.');

}

 ?>
