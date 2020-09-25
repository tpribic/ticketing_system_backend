<?php

declare(strict_types=1);

namespace App\Issue\Application\Resource;


use App\Issue\ContextContract\IssueUserInterface as UserInterface;

final class AssignIssueResource implements IssueResrouceInterface
{
    private string $issueId;
    private string $employeeUsername;

    /**
     * @return string
     */
    public function getIssueId(): string
    {
        return $this->issueId;
    }

    /**
     * @param string $issueId
     * @return AssignIssueResource
     */
    public function setIssueId(string $issueId): AssignIssueResource
    {
        $this->issueId = $issueId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmployeeUsername(): string
    {
        return $this->employeeUsername;
    }

    /**
     * @param string $employeeUsername
     * @return AssignIssueResource
     */
    public function setEmployeeUsername(string $employeeUsername): AssignIssueResource
    {
        $this->employeeUsername = $employeeUsername;
        return $this;
    }



//    /**
//     * @return string
//     */
//    public function getSerialNumber(): string
//    {
//        return $this->serialNumber;
//    }
//
//    /**
//     * @param string $serialNumber
//     * @return AssignIssueResource
//     */
//    public function setSerialNumber(string $serialNumber): AssignIssueResource
//    {
//        $this->serialNumber = $serialNumber;
//        return $this;
//    }

//    /**
//     * @return UserInterface|null
//     */
//    public function getEmployee(): ?UserInterface
//    {
//        return $this->employee;
//    }
//
//    /**
//     * @param UserInterface|null $employee
//     * @return AssignIssueResource
//     */
//    public function setEmployee(?UserInterface $employee): AssignIssueResource
//    {
//        $this->employee = $employee;
//        return $this;
//    }

}