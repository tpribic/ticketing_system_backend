<?php

declare(strict_types=1);

namespace App\Common;


interface IteratorInterface
{
    public function hasNext();

    public function getNext();

    public function getCurrent();
}