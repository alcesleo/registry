<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\MemberModel;

class RegisterMemberView extends CommandLineView
{   

    /**
     * @return string $input
     * TODO: Felhantering i samtliga "set" metoder
     */
    public function setMemberName()
    {
        $input = $this->readLine("\n\nEnter members Name: ");
        return $input;
    }
    
     /**
     * @param string $name
     * @return string $input
     */
    public function setMemberSSN($name)
    {
        $input = $this->readLine("\n\nEnter SSN for ".$name.": ");
        
        return $input;
    }
}
    