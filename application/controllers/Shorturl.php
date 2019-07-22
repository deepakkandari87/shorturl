<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shorturl extends CI_Controller {

	private $string = "abcdfghjkmnpqrstvwxyzABCDFGHJKLMNPQRSTVWXYZ0123456789";

	public function __construct(){

		parent::__construct();

		// Load model
		$this->load->model('Shorturlmodel', 'shorturl');

		// load string helper
		$this->load->helper('string');
	}

	/*
	 Create short url form
	 */
	public function index()
	{
		$data['result'] = [];

		$data['error'] = '';
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$url = $_POST['url'];

			// validate url
			if($this->validateUrl($url)){

				$key = $this->shorturl->saveData($url);

				if($key) {
					$data['result'] = ['code' => $this->encryptString($key)];
				} else {
					$data['error'] = 'Something went wrong. Please try again.';
				}
			} else {
				$data['error'] = 'Url dosn\'t exist. Please enter valid url.';
			}
		}

		$this->load->view('index', $data);
	}

	/*
	 Load short url
	 */
	public function loadShortUrl($token)
	{
		if(!empty($token)){
			
			$key = $this->decryptString($token);

			$result = $this->shorturl->getDetailByKey($key);

			if($result) {
		   
		        /*Redirect to long url*/ 
		        redirect($result->long_url); 
			}	
		}
		$this->load->view('error-page');
	}

	/*
	 View all urls
	 */
	public function viewPage()
	{
		$data['result'] = [];
		
		$result = $this->shorturl->getAllData();
		if(!empty($result)){
			foreach($result as $row){
				$data['result'][] = [ 'code' => $this->encryptString($row->id) ];
			}
		}
		$this->load->view('main', $data);
	}

	/*
	 validate long url
	 */
    private function validateUrl($url) {
    	$headers = get_headers($url);
    	$code = substr($headers[0], 9, 3);
		return $code != '404';
    }

    /*
	 Encrypt string
	 */
	private function encryptString($key) {

		// length of string
		$length = strlen($this->string);

		// generate code
		$code = '';
		while($key > 0 ){

			// get reminder value
			$rem = $key % $length;
			
			// concat tring
			$code = $code . $this->string[$rem];

			// get divide value
			$key = (int) ($key / $length);
		}

		// get unique code
		return $code;
    }

	/*
	 Decrypt string
	 */
	private function decryptString($code) {

		// length of string
		$length = strlen($this->string);

		$key = 0;

		$i=0;
		while($i < strlen($code)){

			$j = 0;
			while($j < $length){

				// check charecter in getting code and string
				if($this->string[$j] == $code[strlen($code) - $i - 1]){

					// convert into key
					$key = $key + ($j * $this->power($length, strlen($code)-$i-1));
					
					break;
				}
				$j++;
			}

			$i++;	
		}
		// get unique code
		return $key;
    }

    /*
     Get power of number
     */
    private function power($number, $p){

    	$pow = 1;
    	$j = 0;
    	while($j < $p){
    		$pow = $pow * $number;
    		$j++;
    	}
    	return $pow;
    }
}
