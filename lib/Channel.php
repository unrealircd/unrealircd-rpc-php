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
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function getAll(): stdClass|array|bool
    {
        $response = $this->connection->query('channel.list');

        if(!is_bool($response)) {
            return $response->list;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Get a channel object
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function get(string $channel): stdClass|array|bool
    {
        $response = $this->connection->query('channel.get', ['channel' => $channel]);

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
