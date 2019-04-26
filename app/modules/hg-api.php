<?php
class hg_api{

    private $key   = null;
    private $error = false;

    function __construct($key = null){

        if(!empty($key)) $this->key = $key;

    }

    function request($endpoint = '', $params = array()){

        $uri = "https://api.hgbrasil.com/".$endpoint."?key=".$this->key."";

        if(is_array($params)){

            foreach($params as $k=>$value){
                if(empty($value)) continue;
                $uri .= $k . '=' . urlencode($value). '&';
            }
            $uri         = substr($uri, 0, -1);
            $response    = @file_get_contents($uri);
            $this->error = false;
            return json_decode($response, true);

        }else{

            $this->error = true;
            return false;
        }
    }

    function is_error(){
        return $this->error();
    }

    function dolar_quotation(){
        $data = $this->request('finance');
        if(!empty($data) && is_array($data['results']['currencies']['USD'])){
            $this->error = false;
            return $data['results']['currencies']['USD'];
        }else{
            $this->error = true;
            return false;

        }
    }
}

?>