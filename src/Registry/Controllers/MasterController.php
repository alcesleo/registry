<?php

namespace Registry\Controllers;

use Registry\Views\MainMenuView;

use Registry\Views\SingleMemberView;
use Registry\Models\MemberModel;

class MasterController
{
    public function __construct()
    {
        $view = new MainMenuView();
        print $view->readMenuOption();
    }
}
