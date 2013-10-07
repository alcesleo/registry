<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\MemberModel;

class RegisterMemberView extends CommandLineView
{   

    /**
     * @var string $input [readLine()]
     * TODO: Felhantering
     */
    public function setMemberName()
    {
        $input = $this->readLine("Enter members Name: ");
        return $input;
    }
    
    public function setMemberSSN($name)
    {
        $input = $this->readLine("Enter SSN for ".$name.": ");
        
        $member = $this->createNewMember($name, $input);
        
        return $member;
    }
    
    public function createNewMember($name, $ssn) {
        $member = new MemberModel(null, $name, $ssn);
        
        return $member;
    }
}
    