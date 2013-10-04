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
        
        $this->memberModelArray = $this->service->getMembers();
    }
    
    /**
     * @var int $memberID
     * @var string $name
     * @var string $ssn
     */
    public function printMemberData()
    {
        print "     \n ----- Member Information -----";
        
        foreach ($this->memberModelArray as $obj) 
        {
            $memberID = $obj->getMemberID();
            $name = $obj->getName();
            $ssn = $obj->getSocialSecurityNumber();
            
            print "
                    \n MemberID : $memberID
                    \n Name : $name
                    \n SSN : $ssn
                    \n ------------------------------";
        }
    }
}