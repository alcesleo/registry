<?php

namespace Registry\Models;

use Registry\Models\BoatModel;

class MemberModel
{
    /**
     * @var int
     */
    private $memberID;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $socialSecurityNumber;

    /**
     * @var BoatModel[]
     */
    private $boats;

    // TODO: Document all functions in MemberModel
    public function __construct($memberID, $name, $socialSecurityNumber, $boats = array())
    {
        $this->setMemberID($memberID);
        $this->setName($name);
        $this->setSocialSecurityNumber($socialSecurityNumber);
        $this->setOwnedBoats($boats);
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
        // TODO: Validation here
        // NOTE: Maybe fancy regex for XXXXXXXX-XXXX
        $this->socialSecurityNumber = $socialSecurityNumber;
    }

    private function setOwnedBoats($boats)
    {
        // TODO: Validation
        $this->boats = $boats;
    }

    public function getMemberID()
    {
        return $this->memberID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSocialSecurityNumber()
    {
        return $this->socialSecurityNumber;
    }

    public function getOwnedBoats() 
    {
        return $this->boats;
    }
}
