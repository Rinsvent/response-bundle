<?php

namespace Rinsvent\ResponseBundle\Response;

class JsonResponse extends \Symfony\Component\HttpFoundation\JsonResponse
{
  public function __construct($data = null, int $status = 200, array $headers = [], bool $json = false)
  {
    parent::__construct(null, $status, $headers, $json);
    $this->data = $data;
  }

  public function getData()
  {
    return $this->data;
  }
}
