<?php

namespace KPG\RestAPI\API\QueryParameters;

use KPG\RestAPI\API\QueryParameters\Util\QueryParameterUtils;
use KPG\RestAPI\API\HTTP\Response;

class Filtering
{
    private array $response_data;
    private string|array $query_parameters;
    private array $possibleFilterArguments = ['eq', 'neq', 'in', 'not', 'gt', 'lt', 'gte', 'lte', 'between'];
    private QueryParameterUtils $query_parameter_utils;

    public function __construct(array $response_data, string|array $query_parameters)
    {
        $this->response_data = $response_data;
        $this->query_parameters = $query_parameters;
        $this->query_parameter_utils = new QueryParameterUtils();
    }

    public function apply(): array
    {
        if (!$this->query_parameter_utils->checkArray($this->query_parameters)) {
            $response = new Response();
            $response->setError('NO_FILTER_SET');
            $response->setResponseCode(400);
            $response->send();
        }
        $option_params = $this->query_parameter_utils->extractFieldOptions($this->query_parameters);
        $filter_parameter = $option_params[array_key_last($option_params)];
        if (!$this->query_parameter_utils->checkIfExists($this->response_data, $option_params)) {
            $response = new Response();
            $response->setError('FILTER_FIELD_NOT_FOUND');
            $response->setResponseCode(400);
        }
        array_pop($option_params);
        if (!in_array($filter_parameter, $this->possibleFilterArguments)) {
            $response = new Response();
            $response->setError('FILTER_NOT_VALID');
            $response->setResponseCode(400);
            $response->send();
        }
        switch ($filter_parameter) {
            case 'eq':
                $this->response_data = $this->filterEqual($this->response_data, $option_params, $this->query_parameters);
                break;
            case 'neq':
                $this->response_data = $this->filterNotEqual($this->response_data, $option_params, $this->query_parameters);
                break;
            case 'in':
                $this->response_data = $this->filterIn($this->response_data, $option_params, $this->query_parameters);
                break;
            case 'not':
                $this->response_data = $this->filterNotIn($this->response_data, $option_params, $this->query_parameters);
                break;
            case 'gt':
                $this->response_data = $this->filterGreaterThan($this->response_data, $option_params, $this->query_parameters);
                break;
            case 'lt':
                $this->response_data = $this->filterLessThan($this->response_data, $option_params, $this->query_parameters);
                break;
            case 'gte':
                $this->response_data = $this->filterGreaterThanOrEqual($this->response_data, $option_params, $this->query_parameters);
                break;
            case 'lte':
                $this->response_data = $this->filterLessThanOrEqual($this->response_data, $option_params, $this->query_parameters);
                break;
            case 'between':
                $this->response_data = $this->filterBetween($this->response_data, $option_params, $this->query_parameters);
                break;
        }

        return $this->response_data;
    }
    public function filterEqual(array $data, array $field, array $filter_value): array
    {
        $response_data = [];
        $value = $filter_value[array_key_first($filter_value)];
        foreach ($data as $item) {
            if ($this->query_parameter_utils->getValueByPath($item, $field) === $value) {
                $response_data[] = $item;
            }
        }

        return $response_data;
    }
    public function filterNotEqual(array $data, array $field, array $filter_value): array
    {
        $response_data = [];
        $value = $filter_value[array_key_first($filter_value)];
        foreach ($data as $item) {
            if ($this->query_parameter_utils->getValueByPath($item, $field) != $value) {
                $response_data[] = $item;
            }
        }
        return $response_data;
    }
    public function filterIn(array $data, array $field, array $filter_value): array
    {
        $response_data = [];
        $values = explode(',', $filter_value[array_key_first($filter_value)]);

        foreach ($data as $item) {
            $common = array_intersect($values, [$this->query_parameter_utils->getValueByPath($item, $field)]);
            if (!empty($common)) {
                $response_data[] = $item;
            }
        }
        return $response_data;
    }
    public function filterNotIn(array $data, array $field, array $filter_value): array
    {
        $response_data = [];
        $values = explode(',', $filter_value[array_key_first($filter_value)]);

        foreach ($data as $item) {
            $common = array_intersect($values, [$this->query_parameter_utils->getValueByPath($item, $field)]);
            if (empty($common)) {
                $response_data[] = $item;
            }
        }
        return $response_data;
    }
    public function filterGreaterThan(array $data, array $field, array $filter_value): array
    {
        $response_data = [];
        $value = $filter_value[array_key_first($filter_value)];
        if (!is_numeric($value)) {
            $response = new Response();
            $response->setError('FILTER_VALUE_NOT_NUMERIC');
            $response->setResponseCode(400);
        }
        foreach ($data as $item) {
            if ($this->query_parameter_utils->getValueByPath($item, $field) > $value) {
                $response_data[] = $item;
            }
        }
        return $response_data;
    }
    public function filterLessThan(array $data, array $field, array $filter_value): array
    {
        $response_data = [];
        $value = $filter_value[array_key_first($filter_value)];
        if (!is_numeric($value)) {
            $response = new Response();
            $response->setError('FILTER_VALUE_NOT_NUMERIC');
            $response->setResponseCode(400);
        }
        foreach ($data as $item) {
            if ($this->query_parameter_utils->getValueByPath($item, $field) < $value) {
                $response_data[] = $item;
            }
        }
        return $response_data;
    }
    public function filterGreaterThanOrEqual(array $data, array $field, array $filter_value): array
    {
        $response_data = [];
        $value = $filter_value[array_key_first($filter_value)];
        if (!is_numeric($value)) {
            $response = new Response();
            $response->setError('FILTER_VALUE_NOT_NUMERIC');
            $response->setResponseCode(400);
        }
        foreach ($data as $item) {
            if ($this->query_parameter_utils->getValueByPath($item, $field) >= $value) {
                $response_data[] = $item;
            }
        }
        return $response_data;
    }
    public function filterLessThanOrEqual(array $data, array $field, array $filter_value): array
    {
        $response_data = [];
        $value = $filter_value[array_key_first($filter_value)];
        if (!is_numeric($value)) {
            $response = new Response();
            $response->setError('FILTER_VALUE_NOT_NUMERIC');
            $response->setResponseCode(400);
        }
        foreach ($data as $item) {
            if ($this->query_parameter_utils->getValueByPath($item, $field) <= $value) {
                $response_data[] = $item;
            }
        }
        return $response_data;
    }
    public function filterBetween(array $data, array $field, array $filter_value): array
    {
        $response_data = [];
        $values = explode(',', $filter_value[array_key_first($filter_value)]);
        if (!is_numeric($values[0]) || !is_numeric($values[1])) {
            $response = new Response();
            $response->setError('FILTER_VALUE_NOT_NUMERIC');
            $response->setResponseCode(400);
        }
        foreach ($data as $item) {
            if ($this->query_parameter_utils->getValueByPath($item, $field) >= $values[0] && $this->query_parameter_utils->getValueByPath($item, $field) <= $values[1]) {
                $response_data[] = $item;
            }
        }
        return $response_data;
    }

    public function createMetaData(): array
    {
        return [];
    }
}
