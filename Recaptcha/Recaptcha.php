<?php

namespace Recaptcha;

/**
 * Recaptcha
 *
 * @copyright   All Rights Reserved
 * @author		Fabiano Lima <facodeli@gmail.com>
 * @link        https://www.google.com/recaptcha
 * @version     1.0
 */
class Recaptcha
{
    /**
	 * @access private
	 * @var string
	 */
	private $__apiUrl = 'https://www.google.com/recaptcha/api/siteverify';

    /**
	 * @access private
	 * @var string
	 */
	private $__secretKey = null;

    /**
	 * @access private
	 * @var string
	 */
	private $__response = null;

    /**
	 * @access private
	 * @var bool
	 */
	private $__debug = false;

    /**
	 * @return object $this
	 */
	public function __construct()
	{
       return $this;
    }

    /**
     * @param  string $requestMethod (POST, GET, ...)
	 * @return array
	 */
    public function request($requestMethod = 'POST') {

        $requestData             = array();
        $requestData['secret']   = $this->__secretKey;
        $requestData['response'] = $this->__response;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL           , $this->__apiUrl);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST , $requestMethod);
        curl_setopt($curl, CURLOPT_POSTFIELDS    , http_build_query($requestData));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_VERBOSE       , $this->__debug);
        curl_setopt($curl, CURLOPT_IPRESOLVE     , CURL_IPRESOLVE_V4);

        $response = (object) null;
        $response->result = json_decode(curl_exec($curl));

        if ($this->__debug) {

            $response->error = curl_error  ($curl);
            $response->info  = curl_getinfo($curl);
        }

        curl_close($curl);

        return $response;
    }

    /**
	 * @param  string $apiUrl
	 * @return object $this
	 */
    public function setApiUrl($apiUrl) {

        $this->__apiUrl = $apiUrl;

        return $this;
    }

    /**
	 * @param  string $secretKey
	 * @return object $this
	 */
    public function setSecretKey($secretKey) {

        $this->__secretKey = $secretKey;

        return $this;
    }

    /**
	 * @param  mixed  $response
	 * @return object $this
	 */
    public function setResponse($response) {

        $this->__response = $response;

        return $this;
    }

    /**
     * @param bool $debug
	 * @return void
	 */
    public function setDebug($debug) {

        $this->__debug = $debug;

        return $this;
    }

    /**
	 * @param  mixed  $response
     * @param  string $secretKey
	 * @return bool
	 */
    public static function validate($response, $secretKey) {

        $recaptcha = new \Recaptcha\Recaptcha();
        $recaptcha->setResponse($response);
        $recaptcha->setSecretKey($secretKey);

        $request = $recaptcha->request('POST');

        return $request->result->success;
    }
}