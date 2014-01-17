<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 16.01.14
 * Time: 14:37
 */

namespace Lib\Classes;


use PDO;
use Lib\Classes\Kernel;

class DB {

    private function __construct() {}
    private function __clone() {}


    /**
     * @return PDO
     */
    static private function getPdoObj()
    {
        $pdo_settings = array
        (
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
        );
        $config = Kernel::getConfig();
        //return new PDO("mysql:host={$db_config->host};port={$db_config->port};dbname={$db_config->name}", $db_config->user, $db_config->pass, $pdo_settings);
        return new PDO(
            "mysql:host={$config['host']};dbname={$config['db']}",
            $config['user'],
            $config['pwr'],
            $pdo_settings
        );
    }

    /**
     * @var PDO
     */
    static private $db = null;


    /**
     * @return PDO
     */
    static public function connect() {
        if (!self::$db) {
            self::$db = self::getPdoObj();
        }
        return self::$db;
    }


} 