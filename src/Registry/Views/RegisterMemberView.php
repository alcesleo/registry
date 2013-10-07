<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\MemberModel;

class RegisterMemberView extends CommandLineView
{   

    /**
     * @var string $input [readLine()]
     * TODO: Felhantering i samtliga "set" metoder
     */
    public function setMemberName()
    {
        $input = $this->readLine("\n\nEnter members Name: ");
        return $input;
    }
    
     /**
     * @param string $name
     * @var string $input
     * @var MemberModel $member
     */
    public function setMemberSSN($name)
    {
        $input = $this->readLine("Enter SSN for ".$name.": ");
        
        $member = $this->createNewMember($name, $input);
        
        return $member;
    }
    
    /**
     * @param string $name
     * @param int $ssn
     * @var MemberModel $member
     */
    public function createNewMember($name, $ssn) {
        $member = new MemberModel(null, $name, $ssn);
        
        return $member;
    }
}
    