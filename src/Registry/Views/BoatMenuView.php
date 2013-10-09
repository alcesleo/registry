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
    
    /**
     * @return string $input
     */
    public function getMenuOption() 
    {
        $input = $this->view->readMenuOption();
        return $input;
    }
}