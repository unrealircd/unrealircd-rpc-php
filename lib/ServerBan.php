<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class ServerBan
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
     * @return stdClass
     * @throws Exception
     */
    public function get(string $name, string $type): stdClass
    {
        $response = $this->connection->query('server_ban.get', [
            'name' => $name,
            'type' => $type
        ]);

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
