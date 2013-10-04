<?php

namespace Registry\Views;

use Registry\Views\MenuView;

use Registry\Models\MemberModel;
use Registry\Models\ServiceModel;

use PDO;

class SelectMemberView
{
    
    private $service;
    
    private $memberModelArray;
    
    public function __construct()
    {
        // Create temporary database (lasts as long as the program is running)
        $db = new PDO('sqlite:database/registry.sqlite');
        $this->service = new ServiceModel($db);
        $this->memberModelArray = $this->service->getMembers();
        
    }
    
    /**
     * @var array $menuArray
     * @var MenuView $menu
     * @var memberModel $member
     * @return memberModel $member
     */
    public function getSelectedMember()
    {
        //Sets array for menu
        $menuArray = array();
        foreach ($this->memberModelArray as $obj)
            array_push($menuArray, $obj->getName());
        
        //Start emnu view
        $menu = new MenuView($menuArray);
        
        //Print menu and get selected member-object
        $member = $this->memberModelArray[$menu->readMenuOption("Please select user: ")];

        return $member;
    }

    /**
     * @param integer $memberID [contains memberID from selected member]
     * @var MemberModel $member
     */
    private function getMemberObject($memberID)
    {
        //TODO: Fix database-conn. Right now all return fake object
        $member = new MemberModel(1, "Johan", 1234567890);

        return $member;
    }
}
