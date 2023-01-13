<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class Server
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Return a list of all servers.
     *
     * @throws Exception
     */
    public function getAll(): stdClass|array|bool
    {
        $response = $this->connection->query('server.list');

        if(!is_bool($response)) {
            return $response->list;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Return a server object
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function get(string $nick): stdClass|array|bool
    {
        $response = $this->connection->query('server.get', ['server' => $nick]);

        if (!is_bool($response)) {
            return $response->server;
        }

        return false; // not found
    }

    /**
     * Rehash a server
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function rehash(string $serv): stdClass|array|bool
    {
        return $this->connection->query('server.rehash', ["server" => $serv]);
    }

    /**
     * Connect to a server
     *
     * @param string $name The name of the server, e.g; irc.example.com
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function connect(string $name): stdClass|array|bool
    {
        return $this->connection->query('server.connect', [
            'link' => $name,
        ]);
    }

    /**
     * Disconnects a server
     * 
     * @param string $name The name of the server, e.g; irc.example.com
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function disconnect(string $name): stdClass|array|bool
    {
        return $this->connection->query('server.disconnect', [
            'link' => $name,
        ]);
    }

    /**
     * List modules on the server
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function module_list(): stdClass|array|bool
    {
        return $this->connection->query('server.module_list', [
        ]);
    }

}
