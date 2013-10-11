<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\BoatModel;

class EditBoatView extends CommandLineView
{
    /**
     * @return string action
     */
    public function selectChange() {
        $options = array(
            'l' => 'Change length',
            't' => 'Change boat type',
            'r' => 'Return to main menu'
        );

        $menuView = new MenuView($options, "-----------\n Edit menu \n-----------");
        $action = $menuView->readMenuOption("Please select option: ");
        
        return $action;
    }
    
    /**
     * @param BoatModel $boat
     * @return BoatModel $boat
     */
    public function changeBoatData(BoatModel $boat) {
        $action = $this->selectChange();
        
        if($action == 'l')
        {
            // TODO: No validation!
            $input = $this->readLine("Enter new length: ");
            $boat->setLength($input);
            echo "\n\n Length has been changed!\n\n";
        }
        
        if ($action == 't')
        {
            // TODO: Add boat type alternatives (should it be a view in itself?)
            // also, no validation!
            $input = $this->readLine("Enter new boat type: ");
            $boat->setBoatTypeByID(intval($input));
            echo "\n\n Boat type has been changed!\n\n";
        }
        
        return $boat;
    }
}   