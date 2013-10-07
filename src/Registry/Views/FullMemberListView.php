<?php

namespace Registry\Views;

use Registry\Models\MemberModel;

class FullMemberListView
{
    /**
     * @var array $membersArray of MemberModel
     * @var ServiceModel $serviceModel
     */
    private $memberModelArray;
    private $serviceModel;

    /**
     * @param \Registry\Models\ServiceModel $serviceModel
     */
    public function __construct(\Registry\Models\ServiceModel $serviceModel)
    {
        $this->serviceModel = $serviceModel;
        $this->memberModelArray = $this->serviceModel->getMembersWithBoats();
    }

    public function printFullMemberList()
    {
        print "\n ----- Full member list -----\n\n";

        foreach ($this->memberModelArray as $obj) {
            $memberID = $obj->getMemberID();
            $name = $obj->getName();
            $ssn = $obj->getSocialSecurityNumber();
            $boats = $obj->getOwnedBoats();

            print "\n\n ----- Member Information -----";
            print "\n MemberID : $memberID";
            print "\n Name : $name";
            print "\n SSN : $ssn";
            print "\n\n\t---- Owned boats ----\n";

            if (count($boats)>0) {
                // http://stackoverflow.com/questions/7039010/how-to-make-alignment-on-console-in-php
                $pattern = "\t|%-3s |%-9s |%-6s |\n"; // Used in boat table for each member

                printf($pattern, "ID", "Boat type", "Length"); // Table header
                foreach ($boats as $boat) {
                    $boatID = $boat->getBoatID();
                    $boatType = $boat->getBoatType(); // TODO: "Translate" the int to the type name??
                    $boatLength = $boat->getLength();
                    printf($pattern, $boatID, $boatType, $boatLength);
                }
            } else {
                print "\tMember does not own any boats!";
            }
        }
    }
}
