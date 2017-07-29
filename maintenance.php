<?php
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// Update xml database to change status of sold and failed items
// Calculate the item revenue
// Remove items from xml if they aren't in progress

if (isset($_POST["action"])) {
    $xml = simplexml_load_file("../../data/auction.xml");
    $items = $xml->children();
    if ($_POST["action"] == "check")  {
        foreach($items as $item) {
            if ($item->stt == "in_progress") {
                $time = timeLeft($item);
                if ($time == "0 0 0 0") {
                    if ($item->bp > $item->rp) {
                        $item->stt = "sold";
                    } else {
                        $item->stt = "failed";
                    }
                }
            }
        }

        echo "The process is complete.";
    }

    if ($_POST["action"] == "gen") {
        $xmlDoc = new DomDocument;
        $xmlDoc->load("../../data/auction.xml");
        $xslDoc = new DomDocument;
        $xslDoc->load("maintenance.xsl");
        $proc = new XSLTProcessor;
        $proc->registerPHPFunctions();
        $proc->importStyleSheet($xslDoc);
        echo $proc->transformToXML($xmlDoc);
    }
}

function timeLeft($item) {
    $start = date_create( "$item->sd $item->st");
    $dur = date_interval_create_from_date_string($item->durd.'days + '.$item->durh.'hours + '. $item->durm.'minutes');
    $end = date_add($start, $dur);
    $now = new DateTime();
    $rem = date_diff($now, $end); // false
    //echo $rem;
    return $rem->format('%d %h %i %s');
}

function getRev($inum) {
    $xml = simplexml_load_file("../../data/auction.xml");
    $items = $xml->children();
    foreach($items as $item) {
        if ($inum == $item->inum) {
            if ($item->stt == "sold") {
                $p = $item->bp;
                $c = 0.03;
                return $p * $c;
            }
            if ($item->stt == "failed") {
                $p = $item->rp;
                $c = 0.01;
                return $p * $c;
            }
        }
    }
}

function total() {
    $xml = simplexml_load_file("../../data/auction.xml");
    $items = $xml->children();
    $total = 0;
    foreach($items as $item) {
        if ($item->stt != "in_progress") {
            if ($item->stt == "sold") {
                $p = $item->bp;
                $c = 0.03;
                $total += $p * $c;
            }
            if ($item->stt == "failed") {
                $p = $item->rp;
                $c = 0.01;
                $total += $p * $c;
            }
        }
    }
    $removesold = $xml->xpath("/items/item[stt='sold']");
    $removefail = $xml->xpath("/items/item[stt='failed']");
    unset($removesold[0]);
    unset($removefail[0]);
    return $total;
}
 ?>
