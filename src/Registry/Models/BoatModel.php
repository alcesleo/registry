<?php

namespace Registry\Models;

class BoatModel
{
    /**
     * @var int $boatID
     * @var int $boatType
     * @var float $length in metres
     */
    private $boatID;
    private $boatType;
    private $length;

    /**
     * Constructor
     * @param int $boatID
     * @param int $boatType
     * @param float $length
     */
    public function __construct($boatID, $boatType, $length)
    {
        $this->setBoatID($boatID);
        $this->setBoatType($boatType);
        $this->setLength($length);
    }

    /**
     * @param int $boatID
     */
    public function setBoatID($boatID)
    {
        if (! is_numeric($boatID)) {
            throw new \Exception("BoatID must be numeric");
        }
        $this->boatID = $boatID;
    }

    public function setBoatType($boatType)
    {
        //Validation here
        $this->boatType = $boatType;
    }

    /**
     * @param float $length
     */
    public function setLength($length)
    {
        if (! is_numeric($length)) {
            throw new \Exception("Length must be numeric");
        }
        $this->length = $length;
    }

    /**
     * @return int
     */
    public function getBoatID()
    {
        return $this->boatID;
    }

    /**
     * @return BoatTypeModel
     */
    public function getBoatType()
    {
        return $this->boatType;
    }

    /**
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }
}
