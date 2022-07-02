<?php

namespace UnrealIRCd\Contracts;

interface Ban extends Contract
{
    /**
     * Add a ban for a user.
     * @param  string  $user
     * @param  string  $type
     * @param  array  $params
     * @return bool
     */
    public function add(string $user, string $type, array $params): bool;

    /**
     * @param  string  $user
     * @param  string  $type
     * @param  array  $params
     * @return bool
     */
    public function delete(string $user, string $type, array $params): bool;
}
