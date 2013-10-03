<?php

namespace Registry\Views;

class MainMenuView extends CommandLineView
{
    public function __construct()
    {
        //code...
    }

    public function readMenu()
    {
        $this->showMenu();
        $option = $this->readLine();
    }

    public function showMenu()
    {
        print <<<__MENU__
    l : List all members
    L : List all members (long)
    r : Register new member
    e : Edit member
    s : Select member
__MENU__;
    }
}
