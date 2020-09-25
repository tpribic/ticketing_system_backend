<?php

declare(strict_types=1);

namespace App\Issue\Application\Factory;


use App\Issue\Application\Resource\IssueResrouceInterface;
use Symfony\Component\HttpFoundation\Request;

interface IssueResourceFactoryInterface
{
    public function createIssueFromRequest(Request $request): IssueResrouceInterface;
}