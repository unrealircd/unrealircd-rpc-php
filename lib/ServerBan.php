<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class ServerBan implements Contracts\ServerBan
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Add a ban.
     *
     * @param  string  $user
     * @return stdClass
     * @throws Exception
     */
    public function add(string $name, string $type, string $duration, string $reason): stdClass
    {
        return $this->connection->query('server_ban.add', [
            'name' => $name,
            'type' => $type,
            'reason' => $reason,
            'duration_string' => $duration ?? '1d',
        ]);
    }

    /**
     * Delete a ban.
     *
     * @param  string  $name
     * @return stdClass
     * @throws Exception
     */
    public function delete(string $name, string $type): stdClass
    {
        return $this->connection->query('server_ban.del', [
            'name' => $name,
            'type' => $type,
        ]);
    }

    /**
     * Return a list of all bans.
     *
     * @return stdClass
     * @throws Exception
     */
    public function getAll(): stdClass
    {
        $response = $this->connection->query('server_ban.list');

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Get a specific ban.
     *
     * @param  array  $params
     * @return stdClass
     * @throws Exception
     */
    public function get(array $params): stdClass
    {
        $response = $this->connection->query('server_ban.get', [
            'name' => $params['name'],
            'type' => $params['type']
        ]);

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
