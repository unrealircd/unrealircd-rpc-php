<?php

namespace UnrealIRCd;

use WebSocket;

class Connection
{
    protected WebSocket\Client $connection;

    public function __construct(string $uri, string $api_login, array $options = [])
    {
        $context = $options["context"] ?? stream_context_create();

        if (isset($options["tls_verify"]) && ($options["tls_verify"] == false)) {
            stream_context_set_option($context, 'ssl', 'verify_peer', false);
            stream_context_set_option($context, 'ssl', 'verify_peer_name', false);
        }

        $this->connection = new WebSocket\Client($uri, [
            'context' => $context,
            'headers' => [
                'Authorization' => sprintf('Basic %s', base64_encode($api_login)),
            ],
            'timeout' => 10,
        ]);

    }

    public function query(string $method, array $params = [])
    {
        $rpc = [
            "jsonrpc" => "2.0",
            "method" => $method,
            "params" => $params,
            "id" => 123
        ];

        $json_rpc = json_encode($rpc);

        $this->connection->text($json_rpc);
        $reply = $this->connection->receive();

        $reply = json_decode($reply);

        if ($reply->response) {
            return $reply->response;
        } else {
            return false;
        }
    }
}
