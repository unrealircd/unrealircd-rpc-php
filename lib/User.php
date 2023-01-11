<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class User
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Return a list of all users.
     */
    public function getAll(): stdClass|array|bool
    {
        $response = $this->connection->query('user.list');

        if(!is_bool($response)) {
            return $response->list;
        }

        throw new Exception('Invalid JSON Response from UnrealIRCd RPC.');
    }

    /**
     * Return a user object
     *
     * @return stdClass|array|bool
     */
    public function get(string $nick): stdClass|array|bool
    {
        $response = $this->connection->query('user.get', ['nick' => $nick]);

        if (!is_bool($response)) {
            return $response->client;
        }

        return false; // not found
    }

    /**
     * Set the nickname of a user (changes the nick)
     *
     * @return stdClass|array|bool
     */
    public function set_nick(string $nick, string $newnick): stdClass|array|bool
    {
        return $this->connection->query('user.set_nick', [
            'nick' => $nick,
            'newnick' => $newnick,
        ]);
    }

    /**
     * Set the username/ident of a user
     *
     * @return stdClass|array|bool
     */
    public function set_username(string $nick, string $username): stdClass|array|bool
    {
        return $this->connection->query('user.set_username', [
            'nick' => $nick,
            'username' => $username,
        ]);
    }

    /**
     * Set the realname/gecos of a user
     *
     * @return stdClass|array|bool
     */
    public function set_realname(string $nick, string $realname): stdClass|array|bool
    {
        return $this->connection->query('user.set_realname', [
            'nick' => $nick,
            'realname' => $realname,
        ]);
    }

    /**
     * Set a virtual host (vhost) on the user
     *
     * @return stdClass|array|bool
     */
    public function set_vhost(string $nick, string $vhost): stdClass|array|bool
    {
        return $this->connection->query('user.set_vhost', [
            'nick' => $nick,
            'vhost' => $vhost,
        ]);
    }

    /**
     * Change the user modes of a user.
     *
     * @return stdClass|array|bool
     */
    public function set_mode(string $nick, string $mode, bool $hidden = false): stdClass|array|bool
    {
        return $this->connection->query('user.set_mode', [
            'nick' => $nick,
            'modes' => $mode,
            'hidden' => $hidden,
        ]);
    }

    /**
     * Change the snomask of a user (oper).
     *
     * @return stdClass|array|bool
     */
    public function set_snomask(string $nick, string $snomask, bool $hidden = false): stdClass|array|bool
    {
        return $this->connection->query('user.set_snomask', [
            'nick' => $nick,
            'snomask' => $snomask,
            'hidden' => $hidden,
        ]);
    }

    /**
     * Make user an IRC Operator (oper).
     *
     * @return stdClass|array|bool
     */
    public function set_oper(string $nick, string $oper_account, string $oper_class,
                             string $class = null, string $modes = null,
                             string $snomask = null, string $vhost = null): stdClass|array|bool
    {
        return $this->connection->query('user.set_oper', [
            'nick' => $nick,
            'oper_account' => $oper_account,
            'oper_class' => $oper_class,
            'class' => $class,
            'modes' => $modes,
            'snomask' => $snomask,
            'vhost' => $vhost,
        ]);
    }

    /**
     * Join a user to a channel.
     *
     * @return stdClass|array|bool
     */
    public function join(string $nick, string $channel,
                         string $key = null, bool $force = false): stdClass|array|bool
    {
        return $this->connection->query('user.join', [
            'nick' => $nick,
            'channel' => $channel,
            'key' => $key,
            'force' => $force,
        ]);
    }

    /**
     * Part a user from a channel.
     *
     * @return stdClass|array|bool
     */
    public function part(string $nick, string $channel, bool $force = false): stdClass|array|bool
    {
        return $this->connection->query('user.part', [
            'nick' => $nick,
            'channel' => $channel,
            'force' => $force,
        ]);
    }

    /**
     * Quit a user from IRC. Pretend it is a normal QUIT.
     *
     * @return stdClass|array|bool
     */
    public function quit(string $nick, string $reason): stdClass|array|bool
    {
        return $this->connection->query('user.quit', [
            'nick' => $nick,
            'reason' => $reason,
        ]);
    }

    /**
     * Kill a user from IRC. Show that the user is forcefully removed.
     *
     * @return stdClass|array|bool
     */
    public function kill(string $nick, string $reason): stdClass|array|bool
    {
        return $this->connection->query('user.kill', [
            'nick' => $nick,
            'reason' => $reason,
        ]);
    }
}
