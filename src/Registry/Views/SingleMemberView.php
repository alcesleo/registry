<?php

namespace Registry\Views;

use Registry\Models\MemberModel;

class SingleMemberView
{
    /**
     * @param MemberModel $member
     */
    public function printMemberData(MemberModel $member)
    {
        $memberID = $member->getMemberID();
        $name = $member->getName();
        $ssn = $member->getSocialSecurityNumber();

        print "
        			\n ----- Member Information -----
        			\n MemberID : $memberID
        			\n Name : $name
        			\n SSN : $ssn
        			\n";

        $this->showMenuOptions();
    }

    private function showMenuOptions()
    {
        $options = array(
            'e' => 'Edit this member',
            'd' => 'Delete this memeber',
            'r' => 'Return to main menu'
        );
        $view = new MenuView($options);
        $this->doAction($view->readMenuOption());
    }

    /**
     * @param string $option
     */
    private function doAction($option)
    {
        switch ($option) {
            case 'e':
                print 'Not applied';
                break;
            case 'd':
                print 'Not applied';
                break;
            case 'r':
                break;
        }
    }
}
