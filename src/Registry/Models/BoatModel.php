<?php

namespace Registry\Models;

use Exception;

class BoatModel
{
    /**
     * @var int $boatID
     * @var BoatTypeModel $boatType
     * @var float $length in metres
     */
    private $boatID;
    private $boatType;
    private $length;

    /**
     * Constructor
     * @param int $boatID
     * @param int|BoatTypeModel $boatType
     * @param float $length
     */
    public function __construct($boatID, $boatType, $length)
    {
        $this->setBoatID($boatID);
        $this->setLength($length);

        // Set boat-type depending on parameter type
        // NOTE: Sort of a hack - this way we don't have to change the type in every other file.
        if (is_int($boatType)) {
            $this->setBoatTypeByID($boatType);
        } elseif ($boatType instanceof BoatTypeModel) {
            $this->setBoatType($boatType);
        } else {
            throw new Exception('Not a valid BoatType');
        }
    }

    /**
     * @param int $boatID
     */
    public function setBoatID($boatID)
    {
        // Accept null values in favor of autoincrement
        if (is_numeric($boatID) || $boatID === null) {
            $this->boatID = $boatID;
        } else {
            throw new \Exception("BoatID must be numeric");
        }
    }

    /**
     * @param BoatTypeModel $boatType
     */
    public function setBoatType(BoatTypeModel $boatType)
    {
        //Validation here
        $this->boatType = $boatType;
    }

    /**
     * @param int $boatTypeId
     * @throws Exception If boatTypeId is not a valid boat-type
     */
    public function setBoatTypeByID($boatTypeId)
    {
        $this->boatType = new BoatTypeModel($boatTypeId);
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
