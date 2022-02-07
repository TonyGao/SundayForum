<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\CommonTrait;
use App\Repository\TempObjectFileRepository;

/**
 * @ORM\Entity(repositoryClass=TempObjectFileRepository::class)
 * @ORM\Table(name="temp_object_file")
 */
class TempObjectFile
{
    use CommonTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $objectKey;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $operationID;



    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of objectKey
     *
     * @return  string
     */
    public function getObjectKey()
    {
        return $this->objectKey;
    }

    /**
     * Set the value of objectKey
     *
     * @param  string  $objectKey
     *
     * @return  self
     */
    public function setObjectKey(string $objectKey)
    {
        $this->objectKey = $objectKey;

        return $this;
    }

    /**
     * Get the value of operationID
     *
     * @return  string
     */
    public function getOperationID()
    {
        return $this->operationID;
    }

    /**
     * Set the value of operationID
     *
     * @param  string  $operationID
     *
     * @return  self
     */
    public function setOperationID(string $operationID)
    {
        $this->operationID = $operationID;

        return $this;
    }
}
