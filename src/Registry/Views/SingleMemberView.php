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
    }
}
