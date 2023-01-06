<?php

namespace UnrealIRCd\Contracts;

use stdClass;

interface ServerBan extends Contract
{
    /**
     * Add a ban for a user.
     *
     * @param  string  $user
     * @param  array  $params
     * @return stdClass
     */
    public function add(string $name, string $type, string $duration, string $reason): stdClass;

    /**
     * @param  string  $user
     * @param  array  $params
     * @return stdClass
     */
    public function delete(string $name, string $type): stdClass;
}
