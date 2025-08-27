<?php

namespace KPG\RestAPI\API\QueryParameters\Util;

class QueryParameterUtils
{
    public function checkArray($array)
    {
        return is_array($array);
    }

    public function extractFieldOptions($query_parameter): array|bool
    {
        $array_key = array_key_first($query_parameter);
        $option_key_array = explode('.', $array_key);
        return $option_key_array;
    }

    public function checkIfExists(array $data, array $path): bool
    {
        foreach ($path as $key) {
            if (!is_string($key) && !is_int($key)) {
                return false;
            }
            if (!is_array($data) || !array_key_exists($key, $data)) {
                return false;
            }
            $data = $data[$key];
        }
        return true;
    }

    public function getValueByPath(array $data, array $path): null|array|string
    {
        foreach ($path as $key) {
            if (!is_array($data) || !array_key_exists($key, $data)) {
                return null;
            }
            $data = $data[$key];
        }
        return $data;
    }

    public function getNestedValue(array $data, array $keys)
    {
        foreach ($keys as $key) {
            if (!is_array($data) || !array_key_exists($key, $data)) {
                return null;
            }
            $data = $data[$key];
        }
        return $data;
    }
}
