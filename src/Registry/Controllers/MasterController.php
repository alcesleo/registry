<?php

namespace Registry\Controllers;

use Registry\Views\MenuView;

use Registry\Views\CompactMemberListView;
use Registry\Views\SingleMemberView;
use Registry\Views\SelectMemberView;
use Registry\Models\MemberModel;

class MasterController
{
    // TODO This should probably be in a view
    private $options;

    private $view;

    public function __construct()
    {
        $this->options = array(
            'l' => 'List all members',
            'L' => 'List all members (long)',
            'r' => 'Register new member',
            'e' => 'Edit member',
            's' => 'Select member',
            'q' => 'Exit application'
        );

        $this->view = new MenuView($this->options, "-----------\n Main menu \n-----------");
    }

    /**
     * Run the application
     */
    public function run()
    {
        // Show the menu until app exits
        while (true) {
            $this->doAction($this->view->readMenuOption());
        }
    }

    private function doAction($option)
    {
        switch ($option) {
            case 'l':
                $compactMemberListView = new CompactMemberListView();
                $compactMemberListView->printMemberData();
                break;
            case 'L':
                print 'Long list';
                break;
            case 'r':
                print 'Register';
                break;
            case 'e':
                $selectMemberView = new SelectMemberView();
                $member = $selectMemberView->getSelectedMember();
                print 'Edit';
                break;
            case 's':
                $selectMemberView = new SelectMemberView();
                $singleMemberView = new SingleMemberView();

                // Get the user you want to display/change/etc
                $member = $selectMemberView->getSelectedMember();

                $singleMemberView->printMemberData($member);
                break;
            case 'q':
                print 'Bye bye!'; // Should be in view
                exit(0);
                break;
        }
    }
}
