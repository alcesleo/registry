<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\MemberModel;

class SelectMemberView
{
    /**
     * @var Array of MemberModel $memberModelArray
     */
    private $memberModelArray;

    /**
     * @param array of MemberModel $memberModelArray
     */
    public function __construct($memberModelArray)
    {
        $this->memberModelArray = $memberModelArray;
    }

    /**
     * @return memberModel $member
     */
    public function getSelectedMember($prompt = "Please select user: ")
    {
        //Sets array for menu
        $menuArray = array();
        foreach ($this->memberModelArray as $obj) {
            array_push($menuArray, $obj->getName());
        }

        //Start menu view
        $menu = new MenuView($menuArray);

        //Print menu and get selected member-object
        $member = $this->memberModelArray[$menu->readMenuOption($prompt)];

        return $member;
    }
}
