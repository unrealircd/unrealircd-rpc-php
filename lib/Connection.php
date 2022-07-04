<?php

namespace UnrealIRCd;

use Exception;
use WebSocket;

class Connection
{
    protected WebSocket\Client $connection;

    public function __construct(string $uri, string $api_login, array $options = [])
    {
        $context = $options["context"] ?? stream_context_create();

        if (isset($options["tls_verify"]) && !$options["tls_verify"]) {
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

    /**
     * Encode and send a query to the RPC server.
     *
     * @note I'm not sure on the response type except that it may be either an object or array.
     *
     * @param  string  $method
     * @param  array  $params
     * @return object|array|bool
     * @throws Exception
     */
    public function query(string $method, array $params = []): object|array|bool
    {
        $id = random_int(1, 99999);

        $rpc = [
            "jsonrpc" => "2.0",
            "method" => $method,
            "params" => $params,
            "id" => $id
        ];

        $json_rpc = json_encode($rpc);

        $this->connection->text($json_rpc);
        $reply = $this->connection->receive();

        $reply = json_decode($reply);

        if ($reply->response) {
            if($id !== $reply->id) {
                throw new Exception('Invalid ID. This is not the expected reply.');
            }

            return $reply->response;
        } else {
            return false;
        }
    }
}
