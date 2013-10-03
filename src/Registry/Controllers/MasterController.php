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
        $this->doAction($view->readMenuOption());
    }

    private function doAction($option)
    {
        switch ($option) {
            case 'l':
                print 'List';
                break;
            case 'L':
                print 'Long list';
                break;
            case 'r':
                print 'Register';
                break;
            case 'e':
                print 'Edit';
                break;
            case 's':
				/* START Test-data */
				$singleMemberView = new SingleMemberView();
				$singleMemberView->printMemberData(new MemberModel(1, "Johan", 1234567890));
				/* END Test-data */
                break;
        }
    }
}
