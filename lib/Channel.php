<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class Channel
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Return a list of channels users.
     *
     * @return stdClass
     * @throws Exception
     */
    public function getAll(): stdClass
    {
        $response = $this->connection->query('channel.list');

        if(!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Get a channel object
     *
     * @param  array  $params
     * @return stdClass
     * @throws Exception
     */
    public function get(array $params): stdClass
    {
        $response = $this->connection->query('channel.get', ['channel' => $params['channel']]);

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
