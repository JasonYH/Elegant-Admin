<?php
declare(strict_types=1);

namespace App\Dto;

interface DtoSerializeInterface
{
    public function serialize(): string;
}
