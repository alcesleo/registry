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
    	//Validation here
    	$this->boatID = $boatID;
    }

    private function setOwnerID($ownerID) 
    {
    	// Validation here
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
}
