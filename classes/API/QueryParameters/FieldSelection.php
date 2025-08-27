<?php

namespace KPG\RestAPI\API\QueryParameters;

class FieldSelection
{
    private array $response_data;
    private array $fields;

    public function __construct(array $response_data, string $fields)
    {
        $this->response_data = $response_data;
        $this->fields = explode(',', $fields);
    }

    public function apply(): array
    {
        $new_data = [];
        foreach ($this->response_data as $data) {
            $new_data[] = array_intersect_key($data, array_flip($this->fields));

        }
        return $new_data;
    }
    public function createMetaData(): array
    {
        return $this->fields;
    }
}
