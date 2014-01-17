<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 16.01.14
 * Time: 10:44
 */



if (!defined('STDIN')){
    define('STDIN', fopen("php://stdin","r"));
}

function __autoload($name) {
    $name = str_replace('\\', '/', $name);
    require_once VM_MIG . "/graber/{$name}.php";
}

require_once VM_MIG . '/graber/Lib/simple_html_dom.php';


$kernel = new \Lib\Classes\Kernel();



if (file_exists(VM_MIG_CF)) {
    \Lib\Classes\Kernel::setConfig(require_once VM_MIG_CF);
}





$kernel->run();
