<?php

declare(strict_types=1);

namespace App\Issue\Application\Iterator;


use App\Issue\Application\Resource\IssueResource;

class IssueResourceList
{
    private array $issues = array();
    private int $issueCount = 0;

    public function getIssueCount()
    {
        return $this->issueCount;
    }

    private function setIssueCount($newCount)
    {
        $this->issueCount = $newCount;
    }

    public function getIssue($issueNumberToGet)
    {
        if ((is_numeric($issueNumberToGet)) &&
            ($issueNumberToGet <= $this->getIssueCount())) {
            return $this->issues[$issueNumberToGet];
        } else {
            return NULL;
        }
    }

    public function addIssue(IssueResource $issueResource)
    {
        $this->setIssueCount($this->getIssueCount() + 1);
        $this->issues[$this->getIssueCount()] = $issueResource;
        return $this->getIssueCount();
    }

    public function removeIssue(IssueResource $issueResource)
    {
        $counter = 0;
        while (++$counter <= $this->getIssueCount()) {
            if ($issueResource->getId() ==
                $this->issues[$counter]->getId()) {
                for ($x = $counter; $x < $this->getIssueCount(); $x++) {
                    $this->issues[$x] = $this->issues[$x + 1];
                }
                $this->setIssueCount($this->getIssueCount() - 1);
            }
        }
        return $this->getIssueCount();
    }
}