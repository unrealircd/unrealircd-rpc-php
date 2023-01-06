<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class Spamfilter
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Add a spamfilter.
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function add(string $name, string $match_type, string $spamfilter_targets, string $ban_action, string $ban_duration, string $reason): stdClass|array|bool
    {
        return $this->connection->query('spamfilter.add', [
            'name' => $name,
            'match_type' => $match_type,
            'spamfilter_targets' => $spamfilter_targets,
            'ban_action' => $ban_action,
            'ban_duration' => $ban_duration,
            'reason' => $reason,
        ]);
    }

    /**
     * Delete a spamfilter.
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function delete(string $name, string $match_type, string $spamfilter_targets, string $ban_action): stdClass|array|bool
    {
        return $this->connection->query('spamfilter.del', [
            'name' => $name,
            'match_type' => $match_type,
            'spamfilter_targets' => $spamfilter_targets,
            'ban_action' => $ban_action,
        ]);
    }

    /**
     * Return a list of all spamfilters.
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function getAll(): stdClass|array|bool
    {
        $response = $this->connection->query('spamfilter.list');

        if (!is_bool($response)) {
            return $response->list;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Get a specific spamfilter.
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function get(string $name, string $match_type, string $spamfilter_targets, string $ban_action): stdClass|array|bool
    {
        $response = $this->connection->query('spamfilter.get', [
            'name' => $name,
            'match_type' => $match_type,
            'spamfilter_targets' => $spamfilter_targets,
            'ban_action' => $ban_action,
        ]);

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }
}
