<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class Channel implements Contracts\User
{

    public Connection $connection;

    public function __construct(string $uri, string $api_login, array $options)
    {
        $this->connection = new Connection($uri, $api_login, $options);
    }

    /**
     * Return a list of channels users.
     *
     * @return stdClass
     * @throws Exception
     */
    public function get(): stdClass
    {
        $response = $this->connection->query('channel.list');

        if(!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Return a channel object
     *
     * @param  array  $params
     * @return stdClass
     * @throws Exception
     */
    public function show(array $params): stdClass
    {
        $response = $this->connection->query('channel.get', ['channel' => $params['channel']]);

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
