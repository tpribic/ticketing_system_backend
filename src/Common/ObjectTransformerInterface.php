<?php

declare(strict_types=1);

namespace App\Common;


interface ObjectTransformerInterface
{
    public function fromDomain(object $model): object;

    public function toDomain(object $entity): object;

}