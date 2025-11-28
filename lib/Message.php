<?php

namespace UnrealIRCd;

use Exception;
use stdClass;

class Message
{

    public Connection $connection;

    public function __construct(Connection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Send a PRIVMSG to a user.
     *
     * @param string $nick The nickname of the user to send the message to.
     * @param string $message The message to send.
     * @return stdClass|array|bool
     */
    public function privmsg(string $nick, string $message): stdClass|array|bool
    {
        return $this->connection->query('message.privmsg', [
            'nick' => $nick,
            'message' => $message,
        ]);
    }

    /**
     * Send a NOTICE to a user.
     *
     * @param string $nick The nickname of the user to send the notice to.
     * @param string $message The notice message to send.
     * @return stdClass|array|bool
     */
    public function notice(string $nick, string $message): stdClass|array|bool
    {
        return $this->connection->query('message.notice', [
            'nick' => $nick,
            'message' => $message,
        ]);
    }

    /**
     * Send a custom numeric message to a user.
     *
     * @param string $nick The nickname of the user to send the numeric to.
     * @param int $numeric The numeric code (1-999).
     * @param string $message The message text for the numeric.
     * @return stdClass|array|bool
     */
    public function numeric(string $nick, int $numeric, string $message): stdClass|array|bool
    {
        return $this->connection->query('message.numeric', [
            'nick' => $nick,
            'numeric' => $numeric,
            'message' => $message,
        ]);
    }

    /**
     * Send a standard reply to a user (IRCv3 standard replies).
     *
     * @param string $nick The nickname of the user to send the reply to.
     * @param string $type The type of reply: 'FAIL', 'WARN', or 'NOTE'.
     * @param string $code The reply code.
     * @param string $description The description text.
     * @param string|null $context Optional context for the reply.
     * @return stdClass|array|bool
     */
    public function standardreply(string $nick, string $type, string $code, string $description, ?string $context = null): stdClass|array|bool
    {
        $params = [
            'nick' => $nick,
            'type' => $type,
            'code' => $code,
            'description' => $description,
        ];

        if ($context !== null) {
            $params['context'] = $context;
        }

        return $this->connection->query('message.standardreply', $params);
    }
}
