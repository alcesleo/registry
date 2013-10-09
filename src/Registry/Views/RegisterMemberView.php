<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\MemberModel;

class RegisterMemberView extends CommandLineView
{

    /**
     * @return string
     */
    public function getMemberName()
    {
        while (true) {
            $input = $this->readLine("\n\nEnter members Name: ");
            if ($input == "") {
                print "Name cannot be blank";
            } else {
                return $input;
            }
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public function getMemberSSN($name)
    {
        while (true) {
            $input = $this->readLine("\n\nEnter SSN for ".$name.": ");
            if ($input == "") {
                print "SSN cannot be blank";
            } else {
                return $input;
            }
        }
    }
}
