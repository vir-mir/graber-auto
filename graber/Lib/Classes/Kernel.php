<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 16.01.14
 * Time: 11:04
 */

namespace Lib\Classes;


class Kernel {

    private $_controller = null;
    private $_param = array();
    static private $congig = null;

    static public function setConfig($congig) {
        self::$congig = $congig;
    }

    static public function getConfig() {
        return self::$congig;
    }

    static public function isConfig() {
        return self::$congig?true:false;
    }

    public function run() {
        $this->_getAvg();
        $controller = "\\Lib\\Controller\\" . ucfirst($this->_controller);
        $controller = new $controller();
        $controller->index($this->_param);
    }



    private function _getAvg() {
        $argv = $_SERVER['argv'];
        array_shift($argv);

        if ($argv) {
            $mainComand = array_shift($argv);
            switch ($mainComand) {
                case "-h":
                case "--help":
                    $this->_controller = 'help';
                break;

                case "--site":
                case "-s":
                    $this->_controller = 'site';
                break;

                default:
                    $this->_controller = 'help';
                    $argv['errors'] = array("Warning: is no command '{$mainComand}'!");
                break;

            }

            $this->_param = $argv;

        } else {
            $this->_controller = 'help';
        }

    }

} 