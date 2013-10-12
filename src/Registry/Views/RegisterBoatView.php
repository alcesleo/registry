<?php

namespace Registry\Views;

use Registry\Views\BoatTypeMenuView;

class RegisterBoatView extends CommandLineView
{

    /**
     * @return string
     */
    public function getBoatLength()
    {
        // TODO: Validation
        while (true) {
            $input = $this->readLine("\n\nEnter boat length: ");
            if ($input == "") {
                print "Length cannot be blank";
            } else {
                return $input;
            }
        }
    }

    public function getBoatType() 
    {
        $boatTypeMenuView = new BoatTypeMenuView();
        $boatType = $boatTypeMenuView->getMenuOption();
        return intval($boatType);
    }
}
