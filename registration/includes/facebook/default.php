<?php 
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/* standard config include. */
require_once 'config/database.php';require_once 'config/smarty.php';
require_once 'fb_auth.php';
/* Display Template. */
$smarty->display('test/facebook/default.tpl');
?>