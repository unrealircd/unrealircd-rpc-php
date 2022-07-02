<?php

namespace UnrealIRCd\Contracts;

interface Contract
{
    /**
     * Fetch all of a specific item.
     *
     * @return array
     */
    public function get(): array;

    /**
     * Fetch data about a specific item.
     *
     * @param  string  $item
     * @param  array  $params
     * @return object
     */
    public function show(string $item, array $params): object;
}
