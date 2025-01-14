<?php

final class GeoAccess {
    protected static $webData;
    final static function webData(string $ip = null) {
        if ($ip == null) $ip = $_SERVER['REMOTE_ADDR'];
        $result = json_decode(
            json: file_get_contents(
                filename: "http://www.geoplugin.net/json.gp?ip=$ip"
            ),
            associative: true
        );
        self::$webData = $result;
        return $result;
    }
    final static function get(array $allowedCountries): bool {
        $result = false;

        for ($i = 0; $i < sizeof(value: $allowedCountries); $i++) {
            if ($result !== true && self::$webData['geoplugin_countryCode'] === $allowedCountries[$i])
                $result = true;
        }

        return $result;
    }
}