<?php

const FILTERS = [
    'string' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'string[]' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_REQUIRE_ARRAY
    ],
    'email' => FILTER_SANITIZE_EMAIL,
];

function sanitize(string $input, array $activeFilter): string
{
    $filter = FILTERS[$activeFilter] ?? null;

    if ($filter === null) {
        throw new InputSanitizationError("Invalid filter: $activeFilter");
    }

    $data = filter_var($input, $filter);

    if ($data === false) {
        throw new InputSanitizationError("Failed to sanitize input: $input");
    }

    return $data;
}
