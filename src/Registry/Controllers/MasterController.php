<?php

namespace Registry\Controllers;

use Registry\Views\MenuView;

use Registry\Views\CompactMemberListView;
use Registry\Views\FullMemberListView;
use Registry\Views\SingleMemberView;
use Registry\Views\SelectMemberView;
use Registry\Views\RegisterMemberView;
use Registry\Models\MemberModel;
use Registry\Models\ServiceModel;
use PDO;

class MasterController
{
    // TODO This should probably be in a view
    private $options;

    private $view;

    /**
     * @var Registry\Models\ServiceModel $serviceModel
     */
    private $serviceModel;

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

        $db = new PDO('sqlite:database/registry.sqlite');
        $this->serviceModel = new ServiceModel($db);

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
                $compactMemberListView = new CompactMemberListView($this->serviceModel);
                $compactMemberListView->printMemberData();
                break;
            case 'L':
                $fullMemberListView = new FullMemberListView($this->serviceModel);
                $fullMemberListView->printFullMemberList();
                break;
            case 'r':
                $registerMemberView = new RegisterMemberView();
                $newMemberName = $registerMemberView->setMemberName();
                $newMember = $registerMemberView->setMemberSSN($newMemberName);
                break;
            case 'e':
                $selectMemberView = new SelectMemberView($this->serviceModel);
                $member = $selectMemberView->getSelectedMember();
                print 'Edit';
                break;
            case 's':
                $selectMemberView = new SelectMemberView($this->serviceModel);
                $singleMemberView = new SingleMemberView($this->serviceModel);

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
