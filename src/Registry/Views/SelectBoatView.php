<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\BoatModel;

class SelectBoatView
{
    /**
     * @var Array of BoatModel $boatMemberArray
     */
    private $boatModelArray;

    /**
     * @param array of BoatModel $boatMemberArray (with boats)
     */
    public function __construct($boatModelArray)
    {
        $this->boatModelArray = $boatModelArray;
    }

    /**
     * @return BoatModel $boat
     */
    public function getSelectedBoat()
    {
        //Sets array for menu
        $menuArray = array();
        foreach ($this->boatModelArray as $obj) {
            array_push($menuArray, $obj->getBoatType() . " Length: " .  $obj->getLength()); // TODO: Fix alignment
        }

        //Start menu view
        $menu = new MenuView($menuArray);

        //Print menu and get selected boat-object
        $boat = $this->boatModelArray[$menu->readMenuOption("Please select boat: ")];

        return $boat;
    }
}
