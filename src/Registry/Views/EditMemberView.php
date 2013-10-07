<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\MemberModel;

class EditMemberView extends CommandLineView
{
    /**
     * @var array of string $option
     * @var MenuView $menuView
     * @var string $action
     * @return string action
     */
    public function selectChange() {
        $options = array(
            'n' => 'Change name',
            's' => 'Change SSID',
            'r' => 'Return to main menu'
        );

        $menuView = new MenuView($options, "-----------\n Edit menu \n-----------");
        $action = $menuView->readMenuOption("Please select option: ");
        
        return $action;
    }
    
    /**
     * @param MemberModel $member
     * @return MemberModel $member
     * @var string $action
     * @var string $input
     */
    public function changeMemberData($member) {
        $action = $this->selectChange();
        
        if($action == 'n')
        {
            $input = $this->readLine("Enter new name (".$member->getName()."): ");
            $member->setName($input);
            echo "\n\n Name has been changed!\n\n";
        }
        
        if ($action == 's')
        {
            $input = $this->readLine("Enter new SSID for ".$member->getName()."): ");
            $member->setSocialSecurityNumber($input);
            echo "\n\n SSID has been changed!\n\n";
        }
        
        return $member;
    }
}   