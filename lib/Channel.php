<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class Channel
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Return a list of channels users.
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function getAll(): stdClass|array|bool
    {
        $response = $this->connection->query('channel.list');

        if(!is_bool($response)) {
            return $response->list;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Get a channel object
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function get(string $channel): stdClass|array|bool
    {
        $response = $this->connection->query('channel.get', ['channel' => $channel]);

        if (!is_bool($response)) {
            return $response;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Set and unset modes on a channel.
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function set_mode(string $channel, string $modes, string $parameters): stdClass|array|bool
    {
        return $this->connection->query('channel.set_mode', [
            'channel' => $channel,
            'modes' => $modes,
            'parameters' => $parameters,
        ]);
    }

    /**
     * Set the channel topic.
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function set_topic(string $channel, string $topic,
                              string $set_by=null, string $set_at=null): stdClass|array|bool
    {
        return $this->connection->query('channel.set_topic', [
            'channel' => $channel,
            'topic' => $topic,
            'set_by' => $set_by,
            'set_at' => $set_at,
        ]);
    }

    /**
     * Kick a user from the channel.
     *
     * @return stdClass|array|bool
     * @throws Exception
     */
    public function kick(string $channel, string $nick, string $reason): stdClass|array|bool
    {
        return $this->connection->query('user.kick', [
            'nick' => $nick,
            'channel' => $channel,
            'reason' => $reason,
        ]);
    }
}
