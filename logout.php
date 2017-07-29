<?php
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// clear the session customer data and send user back to login page

session_start();
$_SESSION["customer"] = null;
header("Location: login.htm");
 ?>
