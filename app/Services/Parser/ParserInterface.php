<?php

namespace App\Services\Parser;
/**
 * Parser class must implement this contact
 */
interface ParserInterface
{
    /**
     * convert array to valid json
     * @param array $data
     * @return null|string
     */
    public function toJson(array $data): ?string;
}