<?php

declare(strict_types=1);

namespace App\Common;


interface ObjectTransformerInterface
{
    public function fromDomain(object $object): object;

    public function toDomain(object $object): object;
}