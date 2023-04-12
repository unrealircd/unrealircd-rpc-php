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

    /**
     * Add a timer. Requires UnrealIRCd 6.1.0+
     * @param timer_id		Name of the timer (so you can .del_timer later)
     * @param every_msec	Every -this- milliseconds the command must be executed
     * @param method		The JSON-RPC method to execute (lowlevel name, eg "stats.get")
     * @param params		Parameters to the JSON-RPC call that will be executed, can be NULL
     * @param id		Set JSON-RPC id to be used in the timer, leave NULL for auto id.
     * @return stdClass|array|bool
     */
    public function add_timer(string $timer_id, int $every_msec, string $method, array|null $params = null, $id = null): stdClass|array|bool
    {
        if ($id === null)
            $id = random_int(100000, 999999); /* above the regular query() ids */

        $request = [
            "jsonrpc" => "2.0",
            "method" => $method,
            "params" => $params,
            "id" => $id
        ];

        return $this->connection->query('rpc.add_timer', [
            'timer_id' => $timer_id,
            'every_msec' => $every_msec,
            'request' => $request,
        ]);
    }

    /**
     * Delete a timer. Requires UnrealIRCd 6.1.0+
     * @param timer_id		Name of the timer that was added through del_timer earlier.
     * @return stdClass|array|bool
     */
    public function del_timer(string $timer_id)
    {
        return $this->connection->query('rpc.del_timer', [
            'timer_id' => $timer_id,
        ]);
    }
}
