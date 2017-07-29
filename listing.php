<?php
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// Validate new item inputs
// Update xml database with new item
// Get categories from xml

session_start(); // NOTE start new or resume
if (empty($_SESSION["customer"])) {
    echo "failure";
} else {
    $cus = $_SESSION["customer"];
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "getlist") {
            // check xml exists ? continue : create new
            $xml = new DomDocument();
            $inum = 0;
            if (!file_exists("../../data/auction.xml"))
            {
                $root = $xml->createElement("items");
                $xml->appendChild($root);
                $xml->save("../../data/auction.xml");
            } else {
                $xml->load("../../data/auction.xml");
                $sXML = simplexml_load_file("../../data/auction.xml");
                $items = $sXML->children();
                foreach($items as $item) {
                    if ($inum == $item->inum) {
                        break;
                    }
                    $inum = $item->inum;
                }
                $inum += 1;
            }
            $xml->formatOutput = true;


            // array of item - representing the item tree
            // this is a new item
            $item = array(
                "inum"  => $inum,
                "st"    => date("H:i:s"),     // start time
                "sd"    => date("Y/m/d"),     // start date
                "stt"   => "in_progress",     // status - in progress or failed or sold
                "sid"   => $cus["id"],
                "bid"   => "",                // bidder id
                "bp"    => $_POST["sp"],       // bidder price - starts as sp
                "iname" => $_POST["iname"],
                "ctg"   => $_POST["ctg"],
                "desc"  => $_POST["desc"],
                "sp"    => $_POST["sp"],
                "rp"    => $_POST["rp"],
                "binp"  => $_POST["binp"],
                "durd"  => $_POST["durd"],
                "durh"  => $_POST["durh"],
                "durm"  => $_POST["durm"]
            );

            $err = array();
            $resu = false;

            // check all inputs entered

            foreach($item as $key=>$val) {
                if (!isset($val) || empty($val)) {
                    if (!($key == "sid" || $key == "bid" || $key == "bp")) {
                        $err[$key] = "This field is required.";
                        $resu = true;
                    }
                }
            }

            if(!$resu) {
                // validate inputs
                if ($item["sp"] > $item["rp"]) {
                    $err["sp"] = "Start price must be equal or less than reserve price.";
                    $err["rp"] = "Resesrve price must be equal or larger than start price.";
                    $resu = true;
                }
                if ($item["rp"] >= $item["binp"]) {
                    $err["rp"] = "Reserve price must be less than buy it now price.";
                    $resu = true;
                }
            }

            // when to echo what
            if ($resu) {
                //echo $err;
                echo json_encode($err);
            } else {

                $sMsg = "Thank you! Your item has been listed in ShopOnline. The item number is " .$item["inum"]. ", and the bidding starts now: " . $item["st"] . " on " . $item["sd"];

                $reply = array(
                    "success" => toXml($xml, $item),
                    "sMsg"    => $sMsg
                );

                echo json_encode($reply);
            }
        }

        if ($_POST["action"] == "getcat") {
            $ctgs = array();
            array_push($ctgs, "random");
            if (file_exists("../../data/auction.xml")) {
                $xml = simplexml_load_file("../../data/auction.xml");
                $items = $xml->children();
                foreach($items as $item) {
                    $exist = false;
                    foreach($ctgs as $ctg) {
                        if ($item->ctg == $ctg) {
                            $exist = true;
                            break;
                        }
                    }
                    if (!$exist) {
                        array_push($ctgs, (string)$item->ctg);
                    }
                }
            }
            echo json_encode($ctgs, JSON_FORCE_OBJECT);
        }
    }
}

function toXml($xml, $newIt)
{
    $root = $xml->documentElement;
    // add new customer to xml
    $oneItem = $xml->createElement("item");
    $oneItem = $root->appendChild($oneItem);

    $itN  = $xml->createElement("iname");
    $itN  = $oneItem->appendChild($itN);
    $itNV = $xml->createTextNode($newIt["iname"]);
    $itNV = $itN->appendChild($itNV);

    $itSid  = $xml->createElement("sid");
    $itSid  = $oneItem->appendChild($itSid);
    $itSidV = $xml->createTextNode($newIt["sid"]);
    $itSidV = $itSid->appendChild($itSidV);

    $itCat  = $xml->createElement("ctg");
    $itCat  = $oneItem->appendChild($itCat);
    $itCatV = $xml->createTextNode($newIt["ctg"]);
    $itCatV = $itCat->appendChild($itCatV);

    $itDes  = $xml->createElement("desc");
    $itDes  = $oneItem->appendChild($itDes);
    $itDesV = $xml->createTextNode($newIt["desc"]);
    $itDesV = $itDes->appendChild($itDesV);

    $itSp  = $xml->createElement("sp");
    $itSp  = $oneItem->appendChild($itSp);
    $itSpV = $xml->createTextNode($newIt["sp"]);
    $itSpV = $itSp->appendChild($itSpV);

    $itRp  = $xml->createElement("rp");
    $itRp  = $oneItem->appendChild($itRp);
    $itRpV = $xml->createTextNode($newIt["rp"]);
    $itRpV = $itRp->appendChild($itRpV);

    $itBinp  = $xml->createElement("binp");
    $itBinp  = $oneItem->appendChild($itBinp);
    $itBinpV = $xml->createTextNode($newIt["binp"]);
    $itBinpV = $itBinp->appendChild($itBinpV);

    $itDurd  = $xml->createElement("durd");
    $itDurd  = $oneItem->appendChild($itDurd);
    $itDurdV = $xml->createTextNode($newIt["durd"]);
    $itDurdV = $itDurd->appendChild($itDurdV);

    $itDurh  = $xml->createElement("durh");
    $itDurh  = $oneItem->appendChild($itDurh);
    $itDurhV = $xml->createTextNode($newIt["durh"]);
    $itDurhV = $itDurh->appendChild($itDurhV);

    $itDurm  = $xml->createElement("durm");
    $itDurm  = $oneItem->appendChild($itDurm);
    $itDurmV = $xml->createTextNode($newIt["durm"]);
    $itDurmV = $itDurm->appendChild($itDurmV);

    $itNm  = $xml->createElement("inum");
    $itNm  = $oneItem->appendChild($itNm);
    $itNmV = $xml->createTextNode($newIt["inum"]);
    $itNmV = $itNm->appendChild($itNmV);

    $itSt  = $xml->createElement("st");
    $itSt  = $oneItem->appendChild($itSt);
    $itStV = $xml->createTextNode($newIt["st"]);
    $itStV = $itSt->appendChild($itStV);

    $itSd  = $xml->createElement("sd");
    $itSd  = $oneItem->appendChild($itSd);
    $itSdV = $xml->createTextNode($newIt["sd"]);
    $itSdV = $itSd->appendChild($itSdV);

    $itStt  = $xml->createElement("stt");
    $itStt  = $oneItem->appendChild($itStt);
    $itSttV = $xml->createTextNode($newIt["stt"]);
    $itSttV = $itStt->appendChild($itSttV);

    $itBid  = $xml->createElement("bid");
    $itBid  = $oneItem->appendChild($itBid);
    $itBidV = $xml->createTextNode($newIt["bid"]);
    $itBidV = $itBid->appendChild($itBidV);

    $itBp  = $xml->createElement("bp");
    $itBp  = $oneItem->appendChild($itBp);
    $itBpV = $xml->createTextNode($newIt["bp"]);
    $itBpV = $itBp->appendChild($itBpV);

    $xml->save("../../data/auction.xml");
    return true;
}

?>
