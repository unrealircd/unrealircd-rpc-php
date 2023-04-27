<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class Log
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Subscribe to log events.
     * Any previous subscriptions are overwritten (lost).
     *
     * @return stdClass|array|bool
     */
    public function subscribe(array $sources): stdClass|array|bool
    {
        return $this->connection->query('log.subscribe', [
            'sources' => $sources,
        ]);
    }

    /**
     * Unsubscribe from all log events.
     *
     * @return stdClass|array|bool
     */
    public function unsubscribe(string $name): stdClass|array|bool
    {
        return $this->connection->query('log.unsubscribe');
    }

    /**
     * Get past log events.
     *
     * @return stdClass|array|bool
     */
    public function getAll(array $sources): stdClass|array|bool
    {
        $response = $this->connection->query('log.list', []);

        if (!is_bool($response) && property_exists($response, 'list'))
            return $response->list;

        return false;
    }
}
