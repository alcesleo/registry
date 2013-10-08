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
            'd' => 'Delete member',
            's' => 'Select single member',
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
                $memberModelArray = $this->serviceModel->getMembersWithBoats();
                $compactMemberListView = new CompactMemberListView($memberModelArray);
                $compactMemberListView->printMemberData();
                break;
            case 'L':
                $memberModelArray = $this->serviceModel->getMembersWithBoats();
                $fullMemberListView = new FullMemberListView($memberModelArray);
                $fullMemberListView->printFullMemberList();
                break;
            case 'r':
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
                break;
            case 'e':
                $memberArray = $this->serviceModel->getMembers();
                $selectMemberView = new SelectMemberView($memberArray);
                $editMemberView = new EditMemberView();
                $member = $selectMemberView->getSelectedMember();
                $altMember = $editMemberView->changeMemberData($member);
                $this->serviceModel->changeMember($altMember);
                break;
            case 'd':
                $memberModelArray = $this->serviceModel->getMembers();
                $selectMemberView = new SelectMemberView($memberModelArray);
                $deleteMemberView = new DeleteMemberView();

                // Get the user you want to delete
                $member = $selectMemberView->getSelectedMember();
                
                // do you realy want to delete this member
                $confirm = $deleteMemberView->userWantsToDeleteMember($member);
                
                //Delete or spare the member
                if($confirm) {
                    $this->serviceModel->removeMember($member);
                    $deleteMemberView->memberDeleted();
                }
                else {
                    $deleteMemberView->memberNotDeleted();
                }
                break;
            case 's':
                $memberModelArray = $this->serviceModel->getMembers();
                $selectMemberView = new SelectMemberView($memberModelArray);
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
