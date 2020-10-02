<?php

declare(strict_types=1);

namespace App\Issue\Application\Iterator;


use App\Issue\Application\Resource\CommentResource;

class CommentResourceList
{
    private array $comments = array();
    private int $commentCount = 0;

    public function getCommentCount()
    {
        return $this->commentCount;
    }

    private function setCommentCount($newCount)
    {
        $this->commentCount = $newCount;
    }

    public function getComment($commentNumberToGet)
    {
        if ((is_numeric($commentNumberToGet)) &&
            ($commentNumberToGet <= $this->getCommentCount())) {
            return $this->comments[$commentNumberToGet];
        } else {
            return NULL;
        }
    }

    public function addComment(CommentResource $commentResource)
    {
        $this->setCommentCount($this->getCommentCount() + 1);
        $this->comments[$this->getCommentCount()] = $commentResource;
        return $this->getCommentCount();
    }

    public function removeComment(CommentResource $commentResource)
    {
        $counter = 0;
        while (++$counter <= $this->getCommentCount()) {
            if ($commentResource->getId() ==
                $this->comments[$counter]->getId()) {
                for ($x = $counter; $x < $this->getCommentCount(); $x++) {
                    $this->comments[$x] = $this->comments[$x + 1];
                }
                $this->setCommentCount($this->getCommentCount() - 1);
            }
        }
        return $this->getCommentCount();
    }
}