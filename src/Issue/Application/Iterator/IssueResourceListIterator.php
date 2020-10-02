<?php

declare(strict_types=1);

namespace App\Issue\Application\Iterator;


use App\Common\IteratorInterface;

class IssueResourceListIterator implements IteratorInterface
{
    protected IssueResourceList $issueList;
    protected int $currentIssue = 0;

    public function __construct(IssueResourceList $issueResourceList)
    {
        $this->issueList = $issueResourceList;
    }

    public function getCurrent()
    {
        if (($this->currentIssue > 0) &&
            ($this->issueList->getIssueCount() >= $this->currentIssue)) {
            return $this->issueList->getIssue($this->currentIssue);
        }
    }

    public function getNext()
    {
        if ($this->hasNext()) {
            return $this->issueList->getIssue(++$this->currentIssue);
        } else {
            return NULL;
        }
    }

    public function hasNext()
    {
        if ($this->issueList->getIssueCount() > $this->currentIssue) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}