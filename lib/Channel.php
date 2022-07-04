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
        $id = random_int(100, 1000);

        $response = $this->connection->query('channel.list');

        if($id !== $response->id) {
            throw new Exception('Invalid ID. This is not the expected reply.');
        }

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
        $id = random_int(100, 1000);

        $response = $this->connection->query('channel.get', ['channel' => $params['channel']]);

        if($id !== $response->id) {
            throw new Exception('Invalid ID. This is not the expected reply.');
        }

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
