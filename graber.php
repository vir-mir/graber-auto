#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 16.01.14
 * Time: 10:40
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);






define('VM_MIG', __DIR__);
define('VM_MIG_TM', VM_MIG . "/graber/templeat/");
define('VM_MIG_DB', VM_MIG . "/graber/db/");
define('VM_MIG_CF', VM_MIG . "/graber/config/config.php");

require_once VM_MIG . '/graber/lib/bootstrap.php';

