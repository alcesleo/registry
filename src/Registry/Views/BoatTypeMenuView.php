<?php

namespace Registry\Views;

use Registry\Views\MenuView;
use Registry\Models\BoatTypeModel;

use Exception;

class BoatTypeMenuView
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
        $this->options = BoatTypeModel::getTypes();

        $this->view = new MenuView($this->options);
    }
    
    /**
     * @return string $input
     */
    public function getMenuOption() 
    {
        $input = $this->view->readMenuOption("Please select boat type: ");
        return $input;
    }
}