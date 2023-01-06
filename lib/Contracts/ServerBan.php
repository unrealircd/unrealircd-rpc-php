<?php

namespace UnrealIRCd\Contracts;

use stdClass;

interface Ban extends Contract
{
    /**
     * Add a ban for a user.
     *
     * @param  string  $user
     * @param  array  $params
     * @return stdClass
     */
    public function add(string $user, array $params): stdClass;

    /**
     * @param  string  $user
     * @param  array  $params
     * @return stdClass
     */
    public function delete(string $user, array $params): stdClass;
}
