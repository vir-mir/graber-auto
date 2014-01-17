<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 16.01.14
 * Time: 11:40
 */

namespace Lib\Classes;


class Output {

    private $text = array();


    public function addText($text, $indent=0, $transfer=true) {
        $mes = (object)array();
        $mes->text = $text;
        $mes->indent = $indent;
        $mes->transfer = $transfer;
        array_push($this->text, $mes);
    }

    public function cleanText() {
        $this->text = [];
    }


    public function addTextArray($text) {
        $this->text = array_merge($this->text, $text);
    }

    public function render($file, $param=array()) {

        $text = file_get_contents($file);
        if (preg_match_all("~\{\{(.*)\}\}~isU", $text, $textParam) > 0) {
            $textParam = array_pop($textParam);
        }
        foreach ($textParam as $p) {
            if (!$p) continue;
            $t = isset($param[$p])?$this->getParam($param[$p]):'';
            $text = str_replace("{{{$p}}}", $t, $text);
        }

        $this->addText($text);
    }

    public function getText() {
        $text = '';
        foreach ($this->text as $obj) {
            $indent = "";
            $i = $obj->indent;
            while($i > 0 && $i-- && $indent .= " ");
            $text .= "{$indent}{$obj->text}";
            $text .= $obj->transfer?"\n":"";
        }
        return $text;
    }

    public function __toString() {
        return $this->getText();
    }

    private function getParam($param) {
        if (is_array($param)) {
            return implode("\n", $param);
        }

        return $param;
    }

} 