<?php

namespace Registry\Controllers;

use Registry\Views\MainMenuView;

class MasterController
{
    public function __construct()
    {
        $view = new MainMenuView();
        print $view->readMenuOption();
    }
}
