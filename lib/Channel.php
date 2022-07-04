<?php

namespace UnrealIRCd;

use Exception;

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
     * @throws Exception
     */
    public function get(): array
    {
        $id = random_int(100, 1000);

        $response = $this->connection->query($id, 'channel.list');

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
     * @return object|bool
     * @throws Exception
     */
    public function show(array $params): object|bool
    {
        $id = random_int(100, 1000);

        $response = $this->connection->query($id, 'channel.get', ['channel' => $params['channel']]);

        if($id !== $response->id) {
            throw new Exception('Invalid ID. This is not the expected reply.');
        }

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
