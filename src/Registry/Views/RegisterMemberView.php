<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\MemberModel;

class RegisterMemberView extends CommandLineView
{

    /**
     * @return string $input
     * TODO: Felhantering i samtliga "get" metoder
     */
    public function getMemberName()
    {
        $input = $this->readLine("\n\nEnter members Name: ");
        return $input;
    }

     /**
     * @param string $name
     * @return string $input
     */
    public function getMemberSSN($name)
    {
        $input = $this->readLine("\n\nEnter SSN for ".$name.": ");

        return $input;
    }
}
