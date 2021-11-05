<?php

namespace Rinsvent\ResponseBundle\EventListener;

use Rinsvent\DTO2Data\Dto2DataConverter;
use Rinsvent\ResponseBundle\Response\JsonResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $response = $event->getResponse();
        if (!$response instanceof JsonResponse) {
            return;
        }

        $data = $response->getRawData();

        if (!is_object($data) && !is_iterable($data)) {
            $response->setData($data);
            return;
        }

        $dto2dataConverter = new Dto2DataConverter();
        $data = $dto2dataConverter->convert($data);
        $response->setData($data);
    }
}
