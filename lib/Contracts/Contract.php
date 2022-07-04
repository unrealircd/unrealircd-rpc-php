<?php

namespace UnrealIRCd\Contracts;

use stdClass;

interface Contract
{
    /**
     * Fetch all of a specific item.
     *
     * @return stdClass
     */
    public function get(): stdClass;

    /**
     * Fetch data about a specific item.
     *
     * @param  array  $params
     * @return stdClass
     */
    public function show(array $params): stdClass;
}
