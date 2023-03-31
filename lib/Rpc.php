<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class Rpc
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Get information on all RPC modules loaded.
     *
     * @return stdClass|array|bool
     */
    public function info(string $nick, string $reason): stdClass|array|bool
    {
        return $this->connection->query('rpc.info');
    }

    /**
     * Set the name of the issuer that will make all the following RPC request
     * (eg. name of logged in user on a webpanel). Requires UnreaIRCd 6.0.8+.
     * @return stdClass|array|bool
     */
    public function set_issuer(string $name): stdClass|array|bool
    {
        return $this->connection->query('rpc.set_issuer', [
            'name' => $name,
        ]);
    }
}
