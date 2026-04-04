<?php 
function autoload($className) {
   include_once __DIR__ . "/{$className}.php";
}
spl_autoload_register('autoload');
?>
