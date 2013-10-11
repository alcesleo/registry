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


    public function __construct($showFullMenu)
    {
        if ($showFullMenu) {
            $this->options = array(
                'r' => 'Register boat',
                'e' => 'Edit boat',
                'd' => 'Delete boat'
            );
        } else {
            $this->options = array(
                'r' => 'Register boat',
            ); 
        }

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