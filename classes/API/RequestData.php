<?php

/**
 * Handles request data management.
 */

namespace KPG\RestAPI\API;

class RequestData
{
    private array $data;

    public function addData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getAllData(): array
    {
        return $this->data;
    }

    public function getValueByKey(string $key): array|string|null
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            return null;
        }
    }
    public function exists(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

}
