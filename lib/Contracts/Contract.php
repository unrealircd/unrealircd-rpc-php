<?php

namespace UnrealIRCd\Contracts;

interface Contract
{
    /**
     * Fetch all of a specific item.
     *
     * @return array|bool
     */
    public function get(): array|bool;

    /**
     * Fetch data about a specific item.
     *
     * @param  array  $params
     * @return object|bool
     */
    public function show(array $params): object|bool;
}
