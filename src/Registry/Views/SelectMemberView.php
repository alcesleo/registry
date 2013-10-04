<?php

namespace Registry\Views;

use Registry\Views\MenuView;

use Registry\Models\MemberModel;
use Registry\Models\ServiceModel;

use PDO;

class SelectMemberView
{
    /**
     * @var ServiceModel $service
     * @var Array of MemberModel $memberModelArray
     */
    private $service;
    private $memberModelArray;


    public function __construct()
    {
        // Create databse and start service
        // TODO: This should not be handled in a view
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
        foreach ($this->memberModelArray as $obj) {
            array_push($menuArray, $obj->getName());
        }

        //Start menu view
        $menu = new MenuView($menuArray);

        //Print menu and get selected member-object
        $member = $this->memberModelArray[$menu->readMenuOption("Please select user: ")];

        return $member;
    }
}
