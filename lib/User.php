<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class User implements Contracts\User
{

    public Connection $connection;

    public function __construct(string $uri, string $api_login, array $options)
    {
        $this->connection = new Connection($uri, $api_login, $options);
    }

    /**
     * Return a list of all users.
     *
     * @throws Exception
     */
    public function get(): stdClass
    {
        $response = $this->connection->query('user.list');

        if(!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Return a user object
     *
     * @param  array  $params
     * @return stdClass
     * @throws Exception
     */
    public function show(array $params): stdClass
    {
        $response = $this->connection->query('user.get', ['nick' => $params['nick']]);

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
