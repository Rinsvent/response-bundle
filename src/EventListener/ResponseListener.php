<?php

namespace Rinsvent\ResponseBundle\EventListener;

use Rinsvent\AttributeExtractor\MethodExtractor;
use Rinsvent\DTO2Data\Dto2DataConverter;
use Rinsvent\ResponseBundle\Attribute\ResponseSchema;
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

        if (is_iterable($data) && 0 === count($data)) {
            $response->setData($data);
            return;
        }

        $dto2dataConverter = new Dto2DataConverter();
        $schema = $this->grabSchema($event);
        $data = $dto2dataConverter->convert($data, $schema);
        $response->setData($data);
    }

    private function grabSchema(ResponseEvent $event): string
    {
        $request = $event->getRequest();
        $controller = $request->get('_controller');
        if (is_string($controller)) {
            $controller = explode('::', $controller);
        }
        if (is_callable($controller)) {
            if (is_object($controller[0])) {
                $controller[0] = get_class($controller[0]);
            }
        }
        if (!is_array($controller) || !count($controller) === 2) {
            throw new \InvalidArgumentException('Response schema not found');
        }
        $methodExtractor = new MethodExtractor($controller[0], $controller[1]);

        /** @var ResponseSchema $responseSchema */
        while ($responseSchema = $methodExtractor->fetch(ResponseSchema::class)) {
            return $responseSchema->schemaClass;
        }
        throw new \InvalidArgumentException('Response schema not found');
    }
}
