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
    // TODO: Should memberID be optional? Autoincrement
    public function __construct($memberID, $name, $socialSecurityNumber, $boats = array())
    {
        $this->setMemberID($memberID);
        $this->setName($name);
        $this->setSocialSecurityNumber($socialSecurityNumber);
        $this->setOwnedBoats($boats);
    }

    public function setMemberID($memberID)
    {
        if (!is_numeric($memberID) and !is_null($memberID)) {
            throw new \Exception("MemberID must be numeric");
        }
        $this->memberID = $memberID;
    }

    public function setName($name)
    {
        if ($name === "") {
            throw new \Exception("Name cannot be blank");
        }
        $this->name = $name;
    }

    public function setSocialSecurityNumber($socialSecurityNumber)
    {
        // TODO: Validation here
        // NOTE: Maybe fancy regex for XXXXXXXX-XXXX
        $this->socialSecurityNumber = $socialSecurityNumber;
    }

    public function setOwnedBoats($boats)
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
