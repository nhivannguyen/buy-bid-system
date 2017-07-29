<?php
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// take in customer bidding price and update it on xml
// return success message to js to display to customer

    session_start();
    if (empty($_SESSION["customer"])) {
        echo "failure";
    } else {
        $cus = $_SESSION["customer"];

        $items = simplexml_load_file("../../data/auction.xml");

        $bp = $_POST["bp"];
        $itNm = $_POST["inum"];
        $bId = $cus["id"];

        foreach($items as $item) {
            if($item->inum == $itNm) {
                if ($bp > $item->bp && $item->stt != "sold") {
                    $item->bp = $bp;
                    $item->bid = $bId;
                    $items->asXML("../../data/auction.xml");
                    echo "Thank you! Your bid is recorded in ShopOnline.";
                } else {
                    echo "Sorry, your bid is not valid.";
                }
            }
        }
    }
?>
