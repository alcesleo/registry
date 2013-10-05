<?php

namespace Registry\Views;

use Registry\Models\MemberModel;
use Registry\Models\ServiceModel;

use PDO;

class CompactMemberListView
{
    /**
     * @var array $membersArray of MemberModel
     * @var ServiceModel $service
     */
    private $memberModelArray;
    private $service;

    /**
     * @var PDO $db
     */
    public function __construct()
    {
        // Create databse and start service
        $db = new PDO('sqlite:database/registry.sqlite');
        $this->service = new ServiceModel($db);
        
        // TODO: Change the call to getAllMembersWithBoats after its been implemented. 
        //$this->memberModelArray = $this->service->getAllMembersWithBoats();
        $this->memberModelArray = $this->service->getMembers();
    }
    
    /**
     * @var int $memberID
     * @var string $name
     * @var string $ssn
     */
    public function printMemberData()
    {
        print "     \n ----- Member list -----\n\n";
        
        // http://stackoverflow.com/questions/7039010/how-to-make-alignment-on-console-in-php
        $pattern = "|%-3s |%-25s |%-11s |%-12s |\n";
        printf($pattern, 'ID', 'Name', 'SSN', 'Nr. of boats'); // Table header

        foreach ($this->memberModelArray as $obj) 
        {
            $memberID = $obj->getMemberID();
            $name = $obj->getName();
            $ssn = $obj->getSocialSecurityNumber();
            $boats = $obj->getOwnedBoats();
            
            printf($pattern, $memberID, $name, $ssn, count($boats));
        }
    }
}
