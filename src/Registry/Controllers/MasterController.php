<?php

namespace Registry\Controllers;

use Registry\Views\MenuView;

use Registry\Views\SingleMemberView;
use Registry\Models\MemberModel;

class MasterController
{
    public function __construct()
    {
        $options = array(
            'l' => 'List all members',
            'L' => 'List all members (long)',
            'r' => 'Register new member',
            'e' => 'Edit member',
            's' => 'Select member'
        );
        $view = new MenuView($options);
        print $view->readMenuOption();
    }
}
