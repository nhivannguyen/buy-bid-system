<?php
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// Return the name of the currently logged in customer
session_start();
if (!empty($_SESSION["customer"])) {
    echo $_SESSION["customer"]["fname"];
} else {
    echo "stranger";
}
 ?>
