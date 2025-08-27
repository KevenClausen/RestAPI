<?php

namespace KPG\RestAPI\API\QueryParameters;

use KPG\RestAPI\API\HTTP\Response;
use KPG\RestAPI\API\QueryParameters\Util\QueryParameterUtils;

class Searching
{
    private array $response_data;
    private QueryParameterUtils $query_parameter_utils;
    private string|array $query_parameters;
    private array $meta_data;

    public function __construct(array $response_data, string|array $query_parameters)
    {
        $this->response_data = $response_data;
        $this->query_parameter_utils = new QueryParameterUtils();
        $this->query_parameters = $query_parameters;
    }

    public function apply(): array
    {
        if ($this->query_parameter_utils->checkArray($this->query_parameters)) {
            $options = $this->query_parameter_utils->extractFieldOptions($this->query_parameters);
            if (!$options) {
                $respones = new Response();
                $respones->setError('SEARCH_FIELD_NOT_VALID');
                $respones->setResponseCode(400);
                $respones->send();
            }
            if (array_key_exists(0, $this->response_data)) {
                $check_data = $this->response_data[0];
            } else {
                $check_data = $this->response_data;
            }
            if (!$this->query_parameter_utils->checkIfExists(
                $check_data,
                $options
            )) {
                $respones = new Response();
                $respones->setError('SEARCH_FIELD_NOT_FOUND');
                $respones->setResponseCode(400);
                $respones->send();
            }
            $new_data = [];
            $last_array_key = array_key_last($options);

            foreach ($this->response_data as $data) {
                if (strpos(
                    $this->query_parameter_utils->getValueByPath(
                        $data,
                        $options
                    ),
                    $this->query_parameters[$options[$last_array_key]]
                ) !== false
                ) {
                    $new_data[] = $data;
                }
            }

            $this->response_data = $new_data;
            $this->meta_data = $options;
        } else {
            $response_array = [];
            foreach ($this->response_data as $key => $value) {
                if ($this->searchInArray($value, $this->query_parameters) !== false) {
                    $response_array[] = $value;
                }
            }
            $this->response_data = $response_array;
            $this->meta_data = [$this->query_parameters];
        }

        return $this->response_data;
    }

    public function createMetaData(): array
    {
        return $this->meta_data;
    }

    private function searchInArray(array $data, string $searchString)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $result = $this->searchInArray($value, $searchString);
                if ($result !== false) {
                    return $data;
                }
            } else {
                if (strpos((string) $value, $searchString) !== false) {
                    return $data;
                }
            }
        }

        return false;
    }
}
