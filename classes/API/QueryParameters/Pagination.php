<?php

namespace KPG\RestAPI\API\QueryParameters;

class Pagination
{
    private array $response_data;
    private int $limit;
    private int $offset;

    public function __construct(array $response_data, ?int $limit = null, ?int $offset = null)
    {
        $this->response_data = $response_data;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function apply(): array
    {

        $this->response_data = array_slice($this->response_data, $this->offset ?? 0, $this->limit ?? count($this->response_data));

        return $this->response_data;
    }
    public function createMetaData(): array
    {
        return [
            'limit' => $this->limit,
            'offset' => $this->offset,
        ];
    }
}
