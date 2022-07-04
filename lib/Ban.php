<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class Ban implements Contracts\Ban
{

    public Connection $connection;

    public function __construct(string $uri, string $api_login, array $options)
    {
        $this->connection = new Connection($uri, $api_login, $options);
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
        $response = $this->connection->query('server_ban.add', [
            'name' => $user,
            'type' => $params['type'],
            'reason' => $params['reason'],
            'length' => $params['length'] ?? '1d',
        ]);

        return $response;
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
        $response = $this->connection->query('server_ban.del', [
            'name' => $user,
            'type' => $params['type'],
        ]);

        return $response;
    }

    /**
     * Return a list of all bans.
     *
     * @return stdClass
     * @throws Exception
     */
    public function get(): stdClass
    {
        $response = $this->connection->query('server_ban.list');

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Show a specific ban.
     *
     * @param  array  $params
     * @return stdClass
     * @throws Exception
     */
    public function show(array $params): stdClass
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
