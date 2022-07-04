<?php

namespace UnrealIRCd;

use Exception;

class Ban implements Contracts\Ban
{

    public Connection $connection;

    public function __construct(string $uri, string $api_login, array $options)
    {
        $this->connection = new Connection($uri, $api_login, $options);
    }

    /**
     * @param  string  $user
     * @param  string  $type
     * @param  array  $params
     * @return bool
     * @throws Exception
     */
    public function add(string $user, string $type, array $params): bool
    {
        $response = $this->connection->query('server_ban.add', [
            'name' => $params['name'],
            'type' => $params['type'],
            'reason' => $params['reason'],
            'length' => $params['length'] ?? '1d',
        ]);

        if (is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * @param  string  $user
     * @param  string  $type
     * @param  array  $params
     * @return bool
     * @throws Exception
     */
    public function delete(string $user, string $type, array $params): bool
    {
        $response = $this->connection->query('server_ban.del', [
            'name' => $params['name'],
            'type' => $params['type'],
        ]);

        if (is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * @return array|bool
     * @throws Exception
     */
    public function get(): array|bool
    {
        $response = $this->connection->query('server_ban.list');

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * @param  array  $params
     * @return object|bool
     * @throws Exception
     */
    public function show(array $params): object|bool
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
