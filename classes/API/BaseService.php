<?php

namespace KPG\RestAPI\API;

use KPG\RestAPI\API\HTTP\Response;

class BaseService
{
    public RequestData $headers;
    public RequestData $params;
    public RequestData $path_params;
    public RequestData $request_body;
    public Response $response;

    public function __construct(array $request_data, Response $response)
    {
        $this->headers = $request_data['headers'];
        $this->params = $request_data['params'];
        $this->path_params = $request_data['path_params'];
        $this->request_body = $request_data['request_body'];
        $this->response = $response;
    }
}
