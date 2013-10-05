<?php

namespace Registry\Models;

class BoatModel
{
    /**
     * @var Int $boatID
     * @var Int $boatType
     * @var Float $length in metres
     */
    private $boatID;
    private $boatType;
    private $length;

    /**
     * Constructor
     * @param Int $boatID
     * @param Int $boatType
     * @param Float $length
     */
    public function __construct($boatID, $boatType, $length)
    {
        $this->setBoatID($boatID);
        $this->setBoatType($boatType);
        $this->setLength($length);
    }

    /**
     * @param Int $boatID
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
     * @param Float $length
     */
    public function setLength($length)
    {
        if (! is_numeric($length)) {
            throw new \Exception("Length must be numeric");
        }
        $this->length = $length;
    }

    /**
     * @return Int
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
     * @return Float
     */
    public function getLength()
    {
        return $this->length;
    }
}
