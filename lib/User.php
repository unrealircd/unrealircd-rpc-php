<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class User
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Return a list of all users.
     *
     * @throws Exception
     */
    public function getAll(): stdClass|array|bool
    {
        $response = $this->connection->query('user.list');

        if(!is_bool($response)) {
            return $response->list;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Return a user object
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function get(string $nick): stdClass|array|bool
    {
        $response = $this->connection->query('user.get', ['nick' => $nick]);

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
