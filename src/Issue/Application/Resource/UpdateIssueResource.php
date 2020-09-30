<?php

declare(strict_types=1);

namespace App\Issue\Application\Resource;


class UpdateIssueResource implements IssueResrouceInterface
{
    private int $issueId;
    private int $employeeId;
    private int $priority;
    private bool $isSolved;

    /**
     * @return int
     */
    public function getIssueId(): int
    {
        return $this->issueId;
    }

    /**
     * @param int $issueId
     * @return UpdateIssueResource
     */
    public function setIssueId(int $issueId): UpdateIssueResource
    {
        $this->issueId = $issueId;
        return $this;
    }

    /**
     * @return int
     */
    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    /**
     * @param int $employeeId
     * @return UpdateIssueResource
     */
    public function setEmployeeId(int $employeeId): UpdateIssueResource
    {
        $this->employeeId = $employeeId;
        return $this;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return UpdateIssueResource
     */
    public function setPriority(int $priority): UpdateIssueResource
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSolved(): bool
    {
        return $this->isSolved;
    }

    /**
     * @param bool $isSolved
     * @return UpdateIssueResource
     */
    public function setIsSolved(bool $isSolved): UpdateIssueResource
    {
        $this->isSolved = $isSolved;
        return $this;
    }

}