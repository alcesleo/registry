<?php

namespace Registry\Models;

class MemberModel
{
	private $memberID;
	private $name;
	private $socialSecurityNumber;

    public function __construct($memberID, $name, $socialSecurityNumber)
    {
        $this->setMemberID($memberID);
    	$this->setName($name);
        $this->setSocialSecurityNumber($socialSecurityNumber);
    }

    private function setMemberID($memberID) 
    {
        if (!is_numeric($memberID)) {
            throw new \Exception("MemberID must be numeric");
        }
        $this->memberID = $memberID;
    }

    private function setName($name) 
    {
        if ($name === "") {
            throw new \Exception("Name cannot be blank");
        }
        $this->name = $name;
    }

    private function setSocialSecurityNumber($socialSecurityNumber) 
    {
        // Validation here
        $this->socialSecurityNumber = $socialSecurityNumber;
    }
}
