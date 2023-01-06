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
     * @param  array  $params
     * @return stdClass
     * @throws Exception
     */
    public function add(string $user, array $params): stdClass
    {
        return $this->connection->query('server_ban.add', [
            'name' => $user,
            'type' => $params['type'],
            'reason' => $params['reason'],
            'duration_string' => $params['length'] ?? '1d',
        ]);
    }

    /**
     * Delete a ban.
     *
     * @param  string  $user
     * @param  array  $params
     * @return stdClass
     * @throws Exception
     */
    public function delete(string $user, array $params): stdClass
    {
        return $this->connection->query('server_ban.del', [
            'name' => $user,
            'type' => $params['type'],
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
