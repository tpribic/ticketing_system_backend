<?php

declare(strict_types=1);

namespace App\Issue\Application\Iterator;


use App\Common\IteratorInterface;

class CommentResourceIterator implements IteratorInterface
{
    protected CommentResourceList $commentList;
    protected int $currentComment = 0;

    public function __construct(CommentResourceList $commentResourceList)
    {
        $this->commentList = $commentResourceList;
    }

    public function getCurrent()
    {
        if (($this->currentComment > 0) &&
            ($this->commentList->getCommentCount() >= $this->currentComment)) {
            return $this->commentList->getComment($this->currentComment);
        }
    }

    public function getNext()
    {
        if ($this->hasNext()) {
            return $this->commentList->getComment(++$this->currentComment);
        } else {
            return NULL;
        }
    }

    public function hasNext()
    {
        if ($this->commentList->getCommentCount() > $this->currentComment) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}