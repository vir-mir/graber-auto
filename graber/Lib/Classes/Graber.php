<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 17.01.14
 * Time: 13:22
 */

namespace Lib\Classes;


use ___PHPSTORM_HELPERS\object;

class Graber {

    private $site,
            $url,
            $auth;

    public function __construct($param) {
        $this->site = $param['name'];
        $this->url = $param['url'];
        $this->domain = $param['domain'];

        if (isset($param['login']) && isset($param['pwr'])) {
            $this->auth = (object)array();
            $this->auth->login = $param['login'];
            $this->auth->pwr = $param['pwr'];
            $this->auth->url_login = $param['url_login'];
            $this->_auth();
        }

    }

    public function getUrl() {
        return $this->url;
    }

    public function getDomain() {
        return $this->domain;
    }

    private function getProxy() {
        $sql = "select * from proxy where is_cur_day = 0 limit 0,1";
        $res = DB::connect()->query($sql);
        if ($res && $res->rowCount()) {
            $proxy = $res->fetchObject();
            return $proxy->proxy;
        }
        return null;
    }

    private function setProxy($proxy) {
        $sql = "update proxy set is_cur_day=1 where proxy = '{$proxy}'";
        return DB::connect()->query($sql);
    }

    private function _auth() {
        $proxy = $this->getProxy();
        $url = $this->auth->url_login;
        $login = $this->auth->login;
        $pass = $this->auth->pwr;

        $ch = curl_init();
        if(strtolower((substr($url,0,5))=='https')) { // если соединяемся с https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        // откуда пришли на эту страницу
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        if ($proxy) curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"{$login[0]}={$login[1]}&{$pass[0]}={$pass[1]}");
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //сохранять полученные COOKIE в файл
        curl_setopt($ch, CURLOPT_COOKIEJAR, VM_MIG_DB.'cookie.txt');
        $result=curl_exec($ch);
        curl_close($ch);
        if ($proxy && strpos($result, 'Превышено число запросов к базе данных в сутки')!==false) {
            $this->setProxy($proxy);
            $this->_auth();
        }

        return $result;
    }


    public function read($url){
        $proxy = $this->getProxy();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        // откуда пришли на эту страницу
        curl_setopt($ch, CURLOPT_REFERER, $url);
        if ($proxy) curl_setopt($ch, CURLOPT_PROXY, $proxy);
        //запрещаем делать запрос с помощью POST и соответственно разрешаем с помощью GET
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        //отсылаем серверу COOKIE полученные от него при авторизации
        curl_setopt($ch, CURLOPT_COOKIEFILE, VM_MIG_DB.'cookie.txt');

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        ob_start();
        curl_exec($ch);
        $result = ob_get_clean();
        if ($proxy && strpos($result, 'Превышено число запросов к базе данных в сутки')!==false) {
            $this->setProxy($proxy);
            $this->read($url);
        }

        curl_close($ch);

        return $result;
    }

} 