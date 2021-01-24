<?php
  // defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');

class Guzzle {
  	function __construct() {
  		$this->_ci = & get_instance();

  		$this->Method = 'POST';
  		$this->URL = base_url().'apis/public/index.php/';
  		$PostData = array();
  	  	require_once('vendor/autoload.php');  
    }

    public function request($URL, $PostData = array()) {
		  $client     = new GuzzleHttp\Client();		  
		try {
			if($this->_ci->session->userdata('apt_token') != '') {
				$PostData = array_merge($PostData, $this->stasticArray());
			}
			// print_r($PostData);
			// print_r($URL);
			// exit;
			# guzzle post request example with form parameter
		    $response = $client->request('POST',$this->URL.$URL, 
		        [
				// 'verify' => false,
		        'form_params' => $PostData,
		        'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
		        ]
					);
					
		    $return['Code'] = $response->getStatusCode(); // 200
		    $return['Phrse'] = $response->getReasonPhrase(); // OK
		    // $return[''] = $response->getProtocolVersion(); // 1.1
		    $return['Body'] = json_decode($response->getBody(), TRUE);
		} catch (GuzzleHttp\Exception\BadResponseException $e) {
		    $response = $e->getResponse();
		    $return['Code'] = $response->getStatusCode(); // 200
		    $return['Phrse'] = $response->getReasonPhrase(); // OK
		    $return['Body'] = json_decode($response->getBody()->getContents(), TRUE);
		}
		// print_r($return);
		// exit;
		return $return;
    }

    public function requestFileUpload($URL, $PostData = array()) {
  		$client     = new GuzzleHttp\Client();
  		// print_r($PostData['file']['tmp_name']);
  		// exit;
		try {
				// if($this->_ci->session->userdata('apt_token') != '') {
				// 	$PostData = array_merge($PostData, $this->stasticArray());
				// }
			# guzzle post request example with form parameter
		    $response = $client->request('POST', $this->URL.$URL, 
		        [
                    'headers' => [
                        'Accept'                => 'application/json',
                        // 'Content-Type'          => 'multipart/form-data'  // <-- commented out this line
                    ],
                    'multipart' => [
                        [
                            'name'     => 'file',
                            'contents' => fopen($PostData['file']['tmp_name'], 'r')
                        ],
                    ],
                ]
		    );
		    // echo "<pre>";
		    // print_r($response);
		    // echo $response->getBody()->getContents();
		    // print_r($response->getBody());
		    // exit;
		    $return['Code'] = $response->getStatusCode(); // 200
		    $return['Phrse'] = $response->getReasonPhrase(); // OK
		    // $return[''] = $response->getProtocolVersion(); // 1.1
		    $return['Body'] = $response->getBody();
		} catch (GuzzleHttp\Exception\BadResponseException $e) {
		    $response = $e->getResponse();
		    $return['Code'] = $response->getStatusCode(); // 200
		    $return['Phrse'] = $response->getReasonPhrase(); // OK
		    $return['Body'] = $response->getBody()->getContents();
		}
		return $return;
	}
    function stasticArray()
    {
    	$stasticArray = array('token' => $this->_ci->session->userdata('apt_token'));
    	return $stasticArray;
    }
}
?>