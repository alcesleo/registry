<?php

namespace Registry\Views;

use Registry\Views\MenuView;

use Registry\Models\MemberModel;

class SelectMemberView
{
    /**
     * @var ServiceModel $serviceModel
     * @var Array of MemberModel $memberModelArray
     */
    private $serviceModel;
    private $memberModelArray;

    /**
     * @param ServiceModelObject $serviceModel 
     */
    public function __construct(\Registry\Models\ServiceModel $serviceModel)
    {
        $this->serviceModel = $serviceModel;
        $this->memberModelArray = $this->serviceModel->getMembers();
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
