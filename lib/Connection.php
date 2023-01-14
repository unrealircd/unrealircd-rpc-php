<?php

namespace UnrealIRCd;

use Exception;
use WebSocket;

class Connection
{
    protected WebSocket\Client $connection;

    public $errno = 0;
    public $error = NULL;

    public function __construct(string $uri, string $api_login, array $options = null)
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

        /* Start the connection now */
        $this->connection->ping();
    }

    /**
     * Encode and send a query to the RPC server.
     *
     * @note I'm not sure on the response type except that it may be either an object or array.
     *
     * @param  string  $method
     * @param  array|null  $params
     *
     * @return object|array|bool
     * @throws Exception
     */
    public function query(string $method, array|null $params = null): object|array|bool
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

        if (property_exists($reply, 'result')) {
            if($id !== $reply->id) {
                throw new Exception('Invalid ID. This is not the expected reply.');
            }
            $this->errno = 0;
            $this->error = NULL;
            return $reply->result;
        }

        if (property_exists($reply, 'error')) {
            $this->errno = $reply->error->code;
            $this->error = $reply->error->message;
            return false;
        }

        /* This should never happen */
        throw new Exception('Invalid JSON-RPC response from UnrealIRCd: not an error and not a result.');
    }

    public function user(): User
    {
        return new User($this);
    }

    public function channel(): Channel
    {
        return new Channel($this);
    }

    public function serverban(): ServerBan
    {
        return new ServerBan($this);
    }

    public function spamfilter(): Spamfilter
    {
        return new Spamfilter($this);
    }
    public function nameban(): NameBan
    {
        return new NameBan($this);
    }
    public function server(): Server
    {
        return new Server($this);
    }
    public function serverbanexception(): ServerBanException
    {
        return new ServerBanException($this);
    }
}
