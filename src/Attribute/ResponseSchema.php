<?php

namespace Rinsvent\ResponseBundle\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class ResponseSchema
{
    public function __construct(
        public string $schemaClass,
    ) {
    }
}
