<?php

declare(strict_types=1);

namespace App\Issue\Application\Resource;


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
}