<?php

declare(strict_types=1);

namespace App\Common;


interface ObjectTransformerInterface
{
    public function fromDomain(object $model, string $targetClass): object;

    public function toDomain(object $entity, string $targetClass): object;

}