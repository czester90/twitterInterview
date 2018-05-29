<?php

namespace Utils;

/**
 * Json Converter
 *
 * @package Utils
 */
class Converter
{
    const JSON_OPTION = JSON_PRETTY_PRINT;

    /**
     * @param array $data Data to be convert from object to array
     *
     * @return array
     */
    public static function toArray(array $data): array
    {
        return json_decode(json_encode($data), true);
    }

    /**
     * @param array $data Data to be convert from object to array
     *
     * @return string a JSON encoded string
     */
    public static function toJson(array $data): string
    {
        return json_encode($data, self::JSON_OPTION);
    }
}