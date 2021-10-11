<?php

namespace App\Entity;

use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

trait CommonTrait
{
    /**
     * use soft delete trait
     * add deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * use timestamp trait to record time of entity
     * add createdAt, updateAt fields
     */
    use TimestampableEntity;

    /**
     * use blameable trait to record modifier etc
     * add createdBy, updatedBy fields
     */
    use BlameableEntity;

    /**
     * Pre persist event listener
     * 
     * @ORM\PrePersist
     */
    public function beforeSave()
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * Pre update event listener
     * 
     * @ORM\PreUpdate
     */
    public function beforeUpdate()
    {
        $this->updatedAt = new \DateTime('now', new \DatetimeZone('UTC'));
    }
}