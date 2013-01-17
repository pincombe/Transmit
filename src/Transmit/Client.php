<?php

namespace Transmit;

class ClientException extends \Exception {}

class Client
{
	public $hostname;
	public $key;

	const TIMEOUT = 2;

	public function __construct($hostname, $key)
	{
		$this->hostname = $hostname;
		$this->key = $key;
	}

	public function get($uri)
	{
		return $this->request($uri);
	}

	public function post($uri, $post_data)
	{
		return $this->request($uri, 'POST', $post_data);
	}

	private function request($uri, $type = 'GET', $post_data = '')
	{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->hostname . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($type == 'POST') {
	        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', sprintf('Key: %s', $this->key)));
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
	}

}