<?php

namespace UnrealIRCdRPC;

use WebSocket;

class Connection
{
	protected $conn;

	public function __construct(string $uri, string $api_login, array $options = [])
	{
		if (isset($options["context"]))
			$context = $options["context"];
		else
			$context = stream_context_create();

		if (isset($options["tls_verify"]) && ($options["tls_verify"] == FALSE))
		{
			stream_context_set_option($context, 'ssl', 'verify_peer', false);
			stream_context_set_option($context, 'ssl', 'verify_peer_name', false);
		}

		$this->conn = new WebSocket\Client($uri, [
			'context' => $context,
			'headers' => [
				'Authorization' => 'Basic '.base64_encode($api_login),
			],
			'timeout' => 10,
		]);

	}

	public function query(string $method, array $params = [])
	{
		$rpc = Array("jsonrpc" => "2.0",
			     "method" => $method,
			     "params" => $params,
			     "id" => 123);
		$json_rpc = json_encode($rpc);
		$this->conn->text($json_rpc);
		$reply = $this->conn->receive();
		$reply = json_decode($reply);
		if ($reply->response)
			return $reply->response;
		return FALSE; // throw error?
	}
}
