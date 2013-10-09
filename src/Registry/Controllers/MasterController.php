<?php

namespace Registry\Controllers;

use Registry\Views\MenuView;

use Registry\Views\CompactMemberListView;
use Registry\Views\FullMemberListView;
use Registry\Views\SingleMemberView;
use Registry\Views\SelectMemberView;
use Registry\Views\EditMemberView;
use Registry\Views\DeleteMemberView;
use Registry\Views\RegisterMemberView;
use Registry\Models\MemberModel;
use Registry\Models\ServiceModel;
use PDO;
use Exception;

class MasterController
{
    // TODO: This should probably be in a view
    private $options;

    /**
     * @var MenuView
     */
    private $view;

    /**
     * @var ServiceModel $serviceModel
     */
    private $serviceModel;

    public function __construct()
    {
        $this->options = array(
            'l' => 'List all members',
            'L' => 'List all members (long)',
            'r' => 'Register new member',
            'e' => 'Edit member',
            'd' => 'Delete member',
            's' => 'Select single member',
            'q' => 'Exit application'
        );

        $db = new PDO(DB_CONNECTION_STRING);
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

    /**
     * Dispatch the correct method based on chosen alternative
     * @param  string $option letter option
     */
    private function doAction($option)
    {
        switch ($option) {
            case 'l':
                $this->showCompactList();
                break;
            case 'L':
                $this->showLongList();
                break;
            case 'r':
                $this->registerMember();
                break;
            case 'e':
                $this->editMember();
                break;
            case 'd':
                $this->deleteMember();
                break;
            case 's':
                $this->selectMember();
                break;
            case 'q':
                $this->quitApplication();
                break;
        }
    }

    private function showCompactList()
    {
        $memberModelArray = $this->serviceModel->getMembersWithBoats();
        $compactMemberListView = new CompactMemberListView($memberModelArray);
        $compactMemberListView->printMemberData();
    }

    private function showLongList()
    {
        $memberModelArray = $this->serviceModel->getMembersWithBoats();
        $fullMemberListView = new FullMemberListView($memberModelArray);
        $fullMemberListView->printFullMemberList();
    }

    // FIXME: Temporary function, might be moved
    private function registerMember()
    {
        // TODO: I think maybe this should be an own controller
        // A lot of validation logic here messing up the nice overview of whats happening. / EL

        $registerMemberView = new RegisterMemberView();

        // Let the user re-enter the name until they get it correct
        do {
            $newMemberName = $registerMemberView->setMemberName();
            if ($newMemberName == "") {
                $noValidName = true;
                print "Name cannot be blank"; // TODO: should not be in controller...?
            } else {
                $noValidName = false;
            }
        } while ($noValidName);

        // TODO: SSN should have more validation!
        do {
            $newMemberSSN = $registerMemberView->setMemberSSN($newMemberName);
            if ($newMemberSSN == "") {
                $noValidSSN = true;
                print "SSN cannot be blank"; // TODO: should not be in controller...?
            } else {
                $noValidSSN = false;
            }
        } while ($noValidSSN);

        try {
            $newMember = new MemberModel(null, $newMemberName, $newMemberSSN);
            $this->serviceModel->addMember($newMember);
        } catch (Exception $ex) {
            // You should normally never get to this catch as we have validated the user data in the do-while's above.
            print ("Something went wrong: " . $ex->getMessage());
        }
    }

    private function editMember()
    {
        $memberArray = $this->serviceModel->getMembers();
        $selectMemberView = new SelectMemberView($memberArray);
        $editMemberView = new EditMemberView();
        $member = $selectMemberView->getSelectedMember();
        $altMember = $editMemberView->changeMemberData($member);
        $this->serviceModel->changeMember($altMember);
    }

    private function deleteMember()
    {
        $memberModelArray = $this->serviceModel->getMembers();
        $selectMemberView = new SelectMemberView($memberModelArray);
        $deleteMemberView = new DeleteMemberView();

        // Get the user you want to delete
        $member = $selectMemberView->getSelectedMember();

        // do you realy want to delete this member
        $confirm = $deleteMemberView->userWantsToDeleteMember($member);

        //Delete or spare the member
        // FIXME: Code duplication
        if ($confirm) {
            $this->serviceModel->removeMember($member);
            $deleteMemberView->memberDeleted();
        } else {
            $deleteMemberView->memberNotDeleted();
        }
    }

    private function selectMember()
    {
        $memberModelArray = $this->serviceModel->getMembers();
        $selectMemberView = new SelectMemberView($memberModelArray);
        $deleteMemberView = new DeleteMemberView();

        // Get the user you want to delete
        $member = $selectMemberView->getSelectedMember();

        // do you realy want to delete this member
        $confirm = $deleteMemberView->userWantsToDeleteMember($member);

        //Delete or spare the member
        // FIXME: Code duplication
        if ($confirm) {
            $this->serviceModel->removeMember($member);
            $deleteMemberView->memberDeleted();
        } else {
            $deleteMemberView->memberNotDeleted();
        }
    }
    private function quitApplication()
    {
        print 'Bye bye!'; // Should be in view
        exit(0);
    }
}
