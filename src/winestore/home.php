<?php
require "authentication.inc"; 
require_once "HTML/Template/ITX.php";

session_start();

// Connect to an authenticated session or relocate to logout.php
sessionAuthenticate();

$template = new HTML_Template_ITX("./templates");
$template->loadTemplatefile("home.tpl", true, true);

$template->setVariable("USERNAME", $_SESSION["loginUsername"]);
$template->parseCurrentBlock();
$template->show();
?>