<?php


namespace App\Issue\Application\Factory;


use App\Issue\Application\Resource\AssignIssueResource;
use App\Issue\Application\Resource\IssueResrouceInterface;
use App\Issue\Application\Resource\IssueResource;
use App\Issue\Application\Resource\UpdateIssueResource;
use Symfony\Component\HttpFoundation\Request;

class IssueResourceFactory implements IssueResourceFactoryInterface
{

    public function createIssueFromRequest(Request $request): IssueResrouceInterface
    {
        switch (true) {
            case !$request->get('isSolved'):
                $newIssueResource = new IssueResource();
                $newIssueResource
                    ->setName($request->get('name'))
                    ->setDescription($request->get('description'))
                    ->setPriority($request->get('priority'))
                    ->setIsSolved(false)
                    ->setSerialNumber($request->get('serialNumber'));
                return $newIssueResource;
            case $request->get('employeeUsername'):
                $assignIssueResource = new AssignIssueResource();
                $assignIssueResource
                    ->setIssueId($request->get('issueId'))
                    ->setEmployeeUsername($request->get('employeeUsername'));
                return $assignIssueResource;
            case $request->get('employeeId'):
                $updateIssueResource = new UpdateIssueResource();
                $updateIssueResource
                    ->setIssueId($request->get('issueId'))
                    ->setPriority($request->get('priority'))
                    ->setEmployeeId($request->get('employeeId'))
                    ->setIsSolved($request->get('isSolved'));
                return $updateIssueResource;
        }
    }
}