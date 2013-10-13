<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\BoatTypeModel;

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
        $boatTypeMenuView = new MenuView(BoatTypeModel::getTypes());
        $boatType = $boatTypeMenuView->readMenuOption();
        return intval($boatType);
    }
}
