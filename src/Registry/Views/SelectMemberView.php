<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\MemberModel;

class SelectMemberView
{
    public function getSelectedMember()
    {

        $memberID = array(
            '1' => 'Johan Andersson',
            '2' => 'Stefan Karlsson',
            '3' => 'Reggie Jacksson',
            '4' => 'Zlatan',
            '5' => 'Peter Griffin'
        );
        $menu = new MenuView($memberID);
        $member = $this->getMemberObject($menu->readMenuOption("Please select user: "));

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
