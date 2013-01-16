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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->hostname . $uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(sprintf('Key: %s', $this->key)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
	}

	public function post($uri, $data)
	{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->hostname . $uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(sprintf('Key: %s', $this->key)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
	}

}