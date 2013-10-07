<?php

namespace Registry\Views;

use Registry\Models\MemberModel;

class CompactMemberListView
{
    /**
     * @var array $membersArray of MemberModel
     */
    private $memberModelArray;

    /**
     * @param array $membersArray of MemberModel $memberModelArray
     */
    public function __construct($memberModelArray)
    {
        $this->memberModelArray = $memberModelArray;
    }

    public function printMemberData()
    {
        print "\n ----- Member list -----\n\n";

        // http://stackoverflow.com/questions/7039010/how-to-make-alignment-on-console-in-php
        $pattern = "|%-3s |%-25s |%-11s |%-12s |\n";
        printf($pattern, 'ID', 'Name', 'SSN', 'Nr. of boats'); // Table header

        foreach ($this->memberModelArray as $obj) {
            $memberID = $obj->getMemberID();
            $name = $obj->getName();
            $ssn = $obj->getSocialSecurityNumber();
            $boats = $obj->getOwnedBoats();

            printf($pattern, $memberID, $name, $ssn, count($boats));
        }
    }
}
