<?php

/**
 * Description of Request
 *
 * @author Mario Costa <mario@computech-it.co.uk>
 */
class Request {

    /**
     *
     * @var string
     */
    private $curl;

    /**
     * Initiates curl 
     */
    public function __construct() {
        $this->curl = curl_init();
    }

    /**
     * Closes curl
     */
    public function __destruct() {
        curl_close($this->curl);
    }

    /**
     * Perform curl request
     * @param $url string
     * @param $data string
     * @return string
     */
    public function executeRequest($url, $data) {

        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_POST, $data);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($this->curl);

        return $response;
    }

}
