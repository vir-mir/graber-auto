<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 16.01.14
 * Time: 11:40
 */

namespace Lib\Classes;


class Input {

    public function getText() {
        $test = fgets(STDIN);
        $test = trim($test);
        $test = strtolower($test);
        return $test;
    }

} 