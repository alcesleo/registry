<?php

namespace Registry\Views;

use Registry\Views\MenuView;

use Exception;

class BoatMenuView
{
    /**
     * @var MenuView $view
     */
    private $view;
    
    /**
     * @var array $options
     */
    private $options;


    public function __construct()
    {
        $this->options = array(
            'a' => 'Add boat',
            'c' => 'Change boat',
            'r' => 'Remove boat'
        );

        $this->view = new MenuView($this->options, "-----------\n Boat menu \n-----------");
    }
    
    public function showMenuOptions() 
    {
        $input = $this->view->readMenuOption();
    }
}