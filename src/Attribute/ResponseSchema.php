<?php

namespace Rinsvent\ResponseBundle\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE)]
class ResponseSchema
{
    public function __construct(
        public string $schemaClass,
    ) {}
}
