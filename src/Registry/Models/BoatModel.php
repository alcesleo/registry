<?php

namespace Registry\Models;

class BoatModel
{
	private $boatID;
	private $ownerID;
	private $boatType;
	private $length;

    public function __construct($boatID, $ownerID, $boatType, $length)
    {
    	$this->setBoatID($boatID);
    	$this->setOwnerID($ownerID);
    	$this->setBoatType($boatType);
    	$this->setLength($length);
    }

    private function setBoatID($boatID) 
    {
    	if (!is_numeric($boatID) {
            throw new \Exception("BoatID must be numeric");
        }
    	$this->boatID = $boatID;
    }

    private function setOwnerID($ownerID) 
    {
    	if (!is_numeric($ownerID) {
            throw new \Exception("OwnerID must be numeric");
        }
    	$this->ownerID = $ownerID;
    }

    private function setBoatType($boatType) 
    {
    	//Validation here
    	$this->boatType = $boatType;
    }

    private function setLength($length) 
    {
    	//Validation here
    	$this->length = $length;
    }

    public function getBoatID() 
    {
        return $this->boatID;
    }

    public function getOwnerID() 
    {
        return $this->ownerID;
    }

    public function getBoatType() 
    {
        return $this->boatType;
    }

    public function getLength() 
    {
        return $this->length;
    }
}
