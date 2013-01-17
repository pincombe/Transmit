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

	protected function _get($uri)
	{
		return $this->_request($uri);
	}

	protected function _post($uri, $post_data)
	{
		return $this->_request($uri, 'POST', $post_data);
	}

	protected function _put($uri, $post_data)
	{
		return $this->_request($uri, 'PUT', $post_data);
	}

	protected function _delete($uri)
	{
		return $this->_request($uri, 'DELETE');
	}

	private function _request($uri, $type = 'GET', $post_data = '')
	{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->hostname . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        if (!empty($post_data)) {
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', sprintf('Key: %s', $this->key)));
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);

        $response = curl_exec($ch);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_status == 404) {
	        throw new ClientException('Unable to fulfil request');
        }

        curl_close($ch);

        //$response = json_decode($response);
        return $response;
	}

}