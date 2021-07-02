<?php
declare(strict_types=1);

namespace App\Dto\Request\Transformer;

use JMS\Serializer\SerializerBuilder;
use Throwable;

abstract class AbstractRequestDtoTransformer implements RequestDtoTransformerInterface
{
    public function serialize(): string
    {
        $serialize = SerializerBuilder::create()->build();
        return $serialize->serialize($this, 'json');
    }

    public function toArray(): array
    {
        $serialize = SerializerBuilder::create()->build();
        try {
            return $serialize->toArray($this);
        } catch (Throwable $ex) {
            return [];
        }
    }
}
