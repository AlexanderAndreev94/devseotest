<?php 
include('data.php');

class Request {

    private $d;
    private $url;

    public function setUrl($url) {
        $this->url = $url;
    }

    public function post($data, $headers) {
        $curl = $this->initCurl($data, $headers);
        $response = curl_exec($curl);
        $info = $this->getInfoFromCurl($curl);

        $this->d = new Data($info['headers'], $response, $info['status_code']);
        curl_close($curl);
        return $this->d;
    }

    public function get($data, $headers) {
        $curl = $this->initCurl($data, $headers, false);
        $response = curl_exec($curl);
        $info = $this->getInfoFromCurl($curl);

        $this->d = new Data($info['headers'], $response, $info['status_code']);
        curl_close($curl);
        return $this->d;
    }

    private function initCurl($data, $headers, $isPost = true) {
        $paramsGet = '';
        $curlParams = array();

        $curl = curl_init();
        if($isPost) {
           $curlParams = array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => $headers
            );
        } else {
            $curlParams = array(
                CURLOPT_URL => $this->url.'?'.$paramsGet,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPGET => true,
                CURLOPT_HTTPHEADER => $headers,
            );
            $paramsGet = $this->getGetParams($data);
        }
        curl_setopt_array($curl, $curlParams);
        return $curl;
    }

    private function getInfoFromCurl($curl) {
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_NOBODY, 1);

        $response = curl_exec($curl);
        return array('status_code' => $code, 'headers' => $response);
    }

    private function getGetParams($params) {
        $paramsStr = '';
        $counter = 0;
        $length = count($params);

        foreach ($params as $key => $param) {
            if($length - 1 == $counter) {
                $paramsStr .= $key.'='.$param;
            } else {
                $paramsStr .= $key.'='.$param.'&';   
            }
            $counter++;
        }
        return $paramsStr;
    }
}

?>