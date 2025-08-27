<?php

namespace KPG\RestAPI\API\QueryParameters;

class Sorting
{
    private array $response_data;
    private string $sort;
    private array $meta;

    public function __construct(array $response_data, string $sort)
    {
        $this->response_data = $response_data;
        $this->sort = $sort;
    }

    public function apply(): array
    {
        $sort_parts = explode(':', $this->sort);
        if (!array_key_exists(1, $sort_parts)) {
            $order = 'desc';
        } else {
            $order = $sort_parts[1];
        }
        $this->meta = [
            'order' => $sort_parts[0],
            'sort' => $order,
        ];
        $sort_key = $sort_parts[0];
        if ($order && is_array($this->response_data)) {
            usort($this->response_data, function ($a, $b) use ($sort_key, $order) {
                $valueA = $a[$sort_key] ?? null;
                $valueB = $b[$sort_key] ?? null;

                if ($valueA == $valueB) {
                    return 0;
                }

                if ($order === 'desc') {
                    return ($valueA > $valueB) ? -1 : 1;
                }
                return ($valueA < $valueB) ? -1 : 1;
            });
        }
        return $this->response_data;
    }
    public function createMetaData(): array
    {
        return $this->meta;
    }
}
