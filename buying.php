<?php
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// update xml file data when a customer buy an item

    session_start();

    if (empty($_SESSION["customer"])) {
        echo "failure";
    } else {
        $cus = $_SESSION["customer"];


        $items = simplexml_load_file("../../data/auction.xml");
        $itNm = $_POST["inum"];
        $bId = $cus["id"];

        foreach($items as $item) {
            if($item->inum == $itNm) {
                $item->bp = $item->binp;
                $item->bid = $cus["id"];
                $item->stt = "sold";
                $items->asXML("../../data/auction.xml");
                echo "Thank you for purchasing this item.";
            }
        }
    }
?>
