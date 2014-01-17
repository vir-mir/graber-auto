<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 16.01.14
 * Time: 11:39
 */

namespace Lib\Controller;

use Lib\Classes\Output;
use Lib\Classes\Input;

class Controller {

    /**
     * @var Output
     */
    protected $output;

    /**
     * @var Input
     */
    protected $input;

    protected $textOut = array();

    protected  function addTextCon($text, $indent=0, $transfer=true) {
        $mes = (object)array();
        $mes->text = $text;
        $mes->indent = $indent;
        $mes->transfer = $transfer;
        array_push($this->textOut, $mes);
    }

    public function __construct() {
        $this->output = new Output();
        $this->input = new Input();
    }

    protected function cleanText($show=false) {
        $this->output->addTextArray($this->textOut);
        if ($show) echo $this->output;
        $this->textOut = [];
        $this->output->cleanText();
    }

    protected function outputHeder($out) {
        $text = $this->output->render(VM_MIG_TM."head.tm", $out);
        $this->output->addText($text);
    }

    protected function render($out, $bot) {
        if(!$bot) $this->outputHeder($out);
        $this->cleanText(true);
        $this->output->addText("\n");
        $this->output->addText("\n");
        if(!$bot) $this->outputFooter();
        $this->cleanText(true);
    }

    protected function outputFooter() {
        $text = $this->output->render(VM_MIG_TM."footer.tm");
        $this->output->addText($text);
    }
} 