<?php

namespace Registry\Models;

class BoatModel
{
    /**
     * @var Integer $boatID
     * @var Integer $memberID
     * @var BoatTypeModel $boatType
     * @var Float $length 
     */
    private $boatID;
    private $ownerID;
    private $boatType;
    private $length;

    /**
     * Constructor 
     * @param Integer $boatID 
     * @param Integer $ownerID 
     * @param BoatTypeModel $boatType // Do we get this as a number or a boatTypeModel???? / EL
     * @param Float $length 
     */
    public function __construct($boatID, $ownerID, $boatType, $length)
    {
        $this->setBoatID($boatID);
        $this->setOwnerID($ownerID);
        $this->setBoatType($boatType);
        $this->setLength($length);
    }

    /**
     * @param Integer $boatID 
     */
    private function setBoatID($boatID)
    {
        if (! is_numeric($boatID)) {
            throw new \Exception("BoatID must be numeric");
        }
        $this->boatID = $boatID;
    }

    /**
     * @param Integer $ownerID 
     */
    private function setOwnerID($ownerID)
    {
        if (! is_numeric($ownerID)) {
            throw new \Exception("OwnerID must be numeric");
        }
        $this->ownerID = $ownerID;
    }

    private function setBoatType($boatType)
    {
        //Validation here
        $this->boatType = $boatType;
    }

    /**
     * @param Float $length 
     */
    private function setLength($length)
    {
        if (! is_numeric($length)) {
            throw new \Exception("Length must be numeric");
        }
        $this->length = $length;
    }

    /**
     * @return Integer
     */
    public function getBoatID()
    {
        return $this->boatID;
    }

    /**
     * @return Integer
     */
    public function getOwnerID()
    {
        return $this->ownerID;
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
