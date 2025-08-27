<?php

namespace KPG\RestAPI\API\QueryParameters;

use KPG\RestAPI\API\RequestData;

class QueryProcessor
{
    private array $response_data;
    private RequestData $parameters;
    private array $meta_data = [];

    public function __construct(array $response_data, $parameters)
    {
        $this->response_data = $response_data;
        $this->parameters = $parameters;
    }

    public function process(): array
    {
        //search
        if ($this->parameters->exists('search')) {
            $obj_query_parameter_search = new Searching(
                $this->response_data,
                $this->parameters->getValueByKey('search')
            );
            $this->response_data = $obj_query_parameter_search->apply();
            $this->setMetadata('search', $obj_query_parameter_search->createMetaData());
        }
        //filter
        if ($this->parameters->exists('filter')) {
            $obj_query_parameter_filter = new Filtering($this->response_data, ($this->parameters->getValueByKey('filter')));
            $this->response_data = $obj_query_parameter_filter->apply();
            $this->setMetadata('filter', $obj_query_parameter_filter->createMetaData());
        }
        //sorting
        if ($this->parameters->exists('sort')) {
            $obj_query_parameter_sorting = new Sorting(
                $this->response_data,
                ($this->parameters->getValueByKey('sort'))
            );
            $this->response_data = $obj_query_parameter_sorting->apply();
            $this->setMetadata('sorting', $obj_query_parameter_sorting->createMetaData());
        }
        //Pagination
        if ($this->parameters->exists('offset') || $this->parameters->exists('limit')) {
            $obj_query_parameter_pagination = new Pagination(
                $this->response_data,
                ((int) $this->parameters->getValueByKey('limit')) ?? null,
                ((int) $this->parameters->getValueByKey('offset')) ?? null
            );
            $this->response_data = $obj_query_parameter_pagination->apply();
            $this->setMetadata('pagination', $obj_query_parameter_pagination->createMetaData());
        }
        //Field Selection
        if ($this->parameters->exists('fields')) {
            $obj_query_parameter_field_selection = new FieldSelection($this->response_data, $this->parameters->getValueByKey('fields'));
            $this->response_data = $obj_query_parameter_field_selection->apply();
            $this->setMetadata('field_selection', $obj_query_parameter_field_selection->createMetaData());
        }

        return $this->response_data;
    }

    private function setMetadata($key, $value)
    {
        $this->meta_data[$key] = $value;
    }

    public function getMetadata()
    {
        return $this->meta_data;
    }

}
