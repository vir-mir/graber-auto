<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 17.01.14
 * Time: 13:10
 */

namespace Lib\Controller;

use Lib\Classes\DB;
use Lib\Classes\Graber;
use Lib\Classes\Kernel;
use Lib\Controller\Controller;

class Site extends Controller{

    public function index($param) {

        $this->outputHeder($param);
        $this->cleanText(true);

        $conf_site = $this->getParams($param);
        $this->$conf_site['name']($conf_site);

        $this->output->addText("\n");
        $this->output->addText("\n");
        $this->outputFooter();
        $this->cleanText(true);
    }


    /**
     * @param Graber $graber
     * @param $html
     */
    private function exist_rase($graber, $html) {
        sleep(5);
        $html = str_get_html($html);
        if (!$html || ($html && !$html->find('.tbl'))) return ;

        $trs = $html->find('.tbl tr');
        $isItem = false;
        $rowspan = 0;
        $cTd = 0;
        foreach ($trs as $tr) {
            $trh = $tr->last_child()->prev_sibling();
            if ($trh) {
                $trh = $trh->find('a', 0);
                if($trh && $trh->innertext()=='Цена') $isItem = true;
            }

            if ($tr->getAttribute('id') && $isItem) {
                if ($cTd == 0) $cTd = count($tr->find('td'));
                $td = $tr->first_child();
                if ($rowspan > 0) {
                    $count = intval($td->text());
                    $td = $td->next_sibling();
                    if ($cTd > 8) $td = $td->next_sibling();
                    $td = $td->next_sibling();
                    $price = str_replace(array(',',' ',), array('.',''), $td->text());
                    $price = trim($price, ' руб.');
                    $price = preg_replace('~[^\d^\.]*~i', '', $price);
                    $price = floatval($price);
                    $sqlParam = array($code, $firma, $des, $count, $price);
                    $sql = "insert into data_exist (code, `name`, descr, `count`, price) values ('".implode("','", $sqlParam)."')";
                    DB::connect()->query($sql);
                    continue;
                } else {
                    $rowspan = $td->getAttribute('rowspan')?intval($td->getAttribute('rowspan')):1;
                }
                $rowspan--;

                if ($td->find('a', 0)) {
                    $firma = $td->find('a', 0)->text();
                } else {
                    $firma = $td->text();
                }

                $td = $td->next_sibling();
                $code = $td->text();

                $td = $td->next_sibling();
                $des = $td->text();

                $td = $td->next_sibling();
                $td = $td->next_sibling();
                $count = intval($td->text());

                $td = $td->next_sibling();
                if ($cTd > 8) $td = $td->next_sibling();
                $td = $td->next_sibling();
                $price = str_replace(array(',',' ',), array('.',''), $td->text());
                $price = trim($price, ' руб.');
                $price = preg_replace('~[^\d^\.]*~i', '', $price);
                $price = floatval($price);
                $sqlParam = array($code, $firma, $des, $count, $price);
                $sql = "insert into data_exist (code, `name`, descr, `count`, price) values ('".implode("','", $sqlParam)."')";
                DB::connect()->query($sql);
            } else {
                $a = $tr->last_child()->find('a', 0);
                if ($a) {
                    $href = $a->getAttribute('href');
                    $newHtml = $graber->read($graber->getDomain() . '/' . $href);
                    $this->exist_rase($graber, $newHtml);
                }
            }
        }
    }


    private function exist($conf_site) {
        $graber = new Graber($conf_site);

        $sql = "select * from code_details";
        $res = DB::connect()->query($sql);
        if ($res && $res->rowCount() > 0) {
            $i = 0;
            while ($code = $res->fetchObject()) {
                if (!$code) continue;
                $code = $code->code;
                $html = $graber->read($graber->getUrl().$code);
                $this->exist_rase($graber, $html);
                $i++;
                if ($i > 20) {
                    sleep(10);
                }
            }
        }



    }


    private function getParams($param) {

        $site = array_shift($param);

        if (intval($site) == 0) {
            $site = 1;
        }

        $conf = Kernel::getConfig();

        if (!isset($conf['site'][$site])) $site = 1;

        return $conf['site'][$site];

    }

} 