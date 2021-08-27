<?php

namespace Rinsvent\ResponseBundle\Response;

class JsonResponse extends \Symfony\Component\HttpFoundation\JsonResponse
{
    protected $rawData;

    public function __construct($data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct(null, $status, $headers, $json);
        $this->rawData = $data;
    }

    public function getRawData()
    {
        return $this->rawData;
    }
}
