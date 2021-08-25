<?php

namespace Rinsvent\ResponseBundle\EventListener;


use App\Response\JsonResponse;
use App\Serializer\EntitySchemaSerializer;

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

        $request = $event->getRequest();
        $data = $response->getData();
        if ($response->getSchema()) {
            // $data = $this->entitySchemaSerializer->serializeBySchema($data, $response->getSchema());
        }

        if ($resultKey = $request->get('_result_key')) {
            $data = [$resultKey => $data];
        }

        $response->setData($data);
    }
}
