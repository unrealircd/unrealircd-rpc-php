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
        if (isset($options["issuer"]))
            $this->query('rpc.set_issuer', ['name' => $options["issuer"] ]);
        else
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

        do {
            $reply = $this->connection->receive();

            $reply = json_decode($reply);

            if (property_exists($reply, 'result')) {
                /* Possibly we are streaming log events, then ignore this event
                 * NOTE: This does mean that this event is "lost"
                 */
                if ($id !== $reply->id)
                    continue;
                $this->errno = 0;
                $this->error = NULL;
                return $reply->result;
            }

            if (property_exists($reply, 'error')) {
                $this->errno = $reply->error->code;
                $this->error = $reply->error->message;
                return false;
            }
        } while(0);

        /* This should never happen */
        throw new Exception('Invalid JSON-RPC response from UnrealIRCd: not an error and not a result.');
    }

    /**
     * Grab and/or wait for next event. Used for log streaming.
     * @note This function will return NULL after a 10 second timeout,
     * this so the function is not entirely blocking. You can safely
     * retry the operation if the return value === NULL.
     *
     * @return object|array|bool|null
     * @throws Exception
     */
    public function eventloop(): object|array|bool|null
    {
        $starttime = microtime(true);
        try {
            $reply = $this->connection->receive();
        } catch (WebSocket\TimeoutException $e) {
            if (microtime(true) - $starttime < 1)
            {
                /* There's some bug in the library: if we
                 * caught the timeout exception once (so
                 * harmless) and then later the server gets
                 * killed or closes the connection otherwise,
                 * then it will again throw WebSocket\TimeoutException
                 * even though it has nothing to do with timeouts.
                 * We detect this by checking if the timeout
                 * took less than 1 second, then we know for sure
                 * that it wasn't really a timeout (since the
                 * timeout is normally 10 seconds).
                 */
                throw $e;
            }
            return NULL;
        }

        $reply = json_decode($reply);

        if (property_exists($reply, 'result')) {
            $this->errno = 0;
            $this->error = NULL;
            return $reply->result;
        }

        /* This would be weird */
        if (property_exists($reply, 'error')) {
            $this->errno = $reply->error->code;
            $this->error = $reply->error->message;
            return false;
        }

        /* This should never happen */
        throw new Exception('Invalid JSON-RPC data from UnrealIRCd: not an error and not a result.');
    }

    public function rpc(): Rpc
    {
        return new Rpc($this);
    }

    public function stats(): Stats
    {
        return new Stats($this);
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

    public function log(): Log
    {
        return new Log($this);
    }
}
