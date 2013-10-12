<?php

namespace Registry\Controllers;

use Registry\Views\MenuView;

use Registry\Views\CompactMemberListView;
use Registry\Views\FullMemberListView;
use Registry\Views\SingleMemberView;
use Registry\Views\SelectMemberView;
use Registry\Views\EditMemberView;
use Registry\Views\DeleteMemberView;
use Registry\Views\DeleteBoatView;
use Registry\Views\BoatMenuView;
use Registry\Views\RegisterMemberView;
use Registry\Views\RegisterBoatView;
use Registry\Views\SelectBoatView;
use Registry\Views\EditBoatView;
use Registry\Models\MemberModel;
use Registry\Models\BoatModel;
use Registry\Models\ServiceModel;
use PDO;
use Exception;

class AppController
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
        // TODO: Break out to view
        $this->options = array(
            'l' => 'List all members',
            'L' => 'List all members (long)',
            'r' => 'Register new member',
            'e' => 'Edit member',
            'd' => 'Delete member',
            's' => 'Select single member',
            'b' => 'Handle boats',
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
                $this->showMemberList();
                break;
            case 'L':
                $this->showMemberList(true);
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
            case 'b':
                $this->handleBoats();
                break;
            case 'q':
                $this->quitApplication();
                break;
        }
    }
    
    private function showBoatMenu(MemberModel $member) 
    {
        $showFullMenu = false;
        if (count($member->getOwnedBoats())>0) {
            $showFullMenu = true;
        }
        $boatMenuView = new BoatMenuView($showFullMenu);
        $option = $boatMenuView->getMenuOption();
        
        $this->doBoatAction($option, $member);
    }
    
    private function doBoatAction($option, MemberModel $member)
    {
        switch ($option) {
            case 'r':
                $this->registerBoat($member);
                break;
            case 'e':
                $this->editBoat($member);
                break;
            case 'd':
                $this->deleteBoat($member);
                break;
        }
    }

    /**
     * Show a list of the members
     * @param  boolean $long long/short format
     */
    private function showMemberList($long = false)
    {
        try {
            $memberModelArray = $this->serviceModel->getMembersWithBoats();

            if ($long) {
                $fullMemberListView = new FullMemberListView($memberModelArray);
                $fullMemberListView->printFullMemberList();
            } else {
                $compactMemberListView = new CompactMemberListView($memberModelArray);
                $compactMemberListView->printMemberData();
            }
        } catch (Exception $ex){
            print("Something went wrong. " . $ex->getMessage());
        }
    }

    /**
     * Create and save a new member
     * @return bool if it was successful
     */
    private function registerMember()
    {
        $registerMemberView = new RegisterMemberView();

        // Get member name
        $newMemberName = $registerMemberView->getMemberName();

        // Get social security number
        // TODO: SSN should have more validation!
        $newMemberSSN = $registerMemberView->getMemberSSN($newMemberName);

        // Create and save the member
        try {
            $newMember = new MemberModel(null, $newMemberName, $newMemberSSN);
            $this->serviceModel->addMember($newMember);
            return true;
        } catch (Exception $ex) {
            // TODO: This should be in a view
            print ("Something went wrong: " . $ex->getMessage());
            return false;
        }
    }

    /**
     * Edit properties of a member
     */
    private function editMember()
    {
        $editMemberView = new EditMemberView();
        try {
            $memberArray = $this->serviceModel->getMembers();
            $selectMemberView = new SelectMemberView($memberArray);
            $member = $selectMemberView->getSelectedMember();

            $altMember = $editMemberView->changeMemberData($member);
            $this->serviceModel->changeMember($altMember);
        } catch (Exception $ex){
            print("Something went wrong. " . $ex->getMessage());
        }
    }

    /**
     * Delete a member from a list of all members
     */
    private function deleteMember()
    {
        // Show list of members
        $memberArray = $this->serviceModel->getMembers();
        $selectMemberView = new SelectMemberView($memberArray);

        // Get the user you want to delete
        $member = $selectMemberView->getSelectedMember();

        $this->deleteMemberWithConfirmation($member);
    }

    /**
     * Delete a member if the user confirms
     * @param  MemberModel $member to delete
     */
    private function deleteMemberWithConfirmation(MemberModel $member)
    {
        $deleteMemberView = new DeleteMemberView();

        // do you realy want to delete this member?
        $confirm = $deleteMemberView->userWantsToDeleteMember($member);

        //Delete or spare the member
        if ($confirm) {
            $this->serviceModel->removeMember($member);
            $deleteMemberView->showMemberDeleted();
        } else {
            $deleteMemberView->showMemberNotDeleted();
        }
    }

    /**
     * Select a member
     */
    private function selectMember()
    {
        $memberModelArray = $this->serviceModel->getMembers();
        $selectMemberView = new SelectMemberView($memberModelArray);

        // Get the user you want to delete
        $member = $selectMemberView->getSelectedMember();

        // TODO: Should we be able to do more stuff here?
        $this->deleteMemberWithConfirmation($member);
    }

        /**
     * Edit properties of a boat
     */
    private function editBoat(MemberModel $member)
    {
        // TODO: exception handling
        $boatArray = $this->serviceModel->getBoats($member);
        $SelectBoatView = new SelectBoatView($boatArray);
        $editBoatView = new EditBoatView();
        $boat = $SelectBoatView->getSelectedBoat();
        $changedBoat = $editBoatView->changeBoatData($boat);
        $this->serviceModel->changeBoat($changedBoat);
    }

    /**
     * Create and save a new boat on a member
     * @return bool if it was successful
     */
    private function registerBoat(MemberModel $member)
    {
        $registerBoatView = new RegisterBoatView();
        $newBoatType = $registerBoatView->getBoatType(); // TODO: FIX THE HARDCODING
        $newBoatLength = $registerBoatView->getBoatLength();

        // Create and save the boat
        try {
            $newBoat = new BoatModel(null, $newBoatType, $newBoatLength);
            $this->serviceModel->addBoat($newBoat, $member);
            return true;
        } catch (Exception $ex) {
            print ("Something went wrong: " . $ex->getMessage());
            return false;
        }
    }

    private function handleBoats() 
    {
        try {
            $memberArray = $this->serviceModel->getMembersWithBoats();
            $selectMemberView = new SelectMemberView($memberArray);
            $member = $selectMemberView->getSelectedMember("Select user to handle boats for");
            $this->showBoatMenu($member);
        } catch (Exception $ex) {
            print ("Something went wrong. " . $ex->getMessage());
        }
    }

    /**
     * @param MemberModel $member
     */
    private function deleteBoat($member)
    {
        // Show list of boats for current member
        $boatArray = $this->serviceModel->getBoats($member);
        $selectBoatView = new SelectBoatView($boatArray);

        // Get the boat you want to delete
        $boat = $selectBoatView->getSelectedBoat();

        $this->deleteBoatWithConfirmation($boat);
    }

    /**
     * Delete a boat if the user confirms
     * @param  BoatModel $boat to delete
     */
    private function deleteBoatWithConfirmation(BoatModel $boat)
    {
        $deleteBoatView = new DeleteBoatView();

        // do you realy want to delete this boat?
        $confirm = $deleteBoatView->userWantsToDeleteBoat($boat);

        //Delete or spare the boat
        if ($confirm) {
            $this->serviceModel->removeBoat($boat);
            $deleteBoatView->showBoatDeleted();
        } else {
            $deleteBoatView->showBoatNotDeleted();
        }
    }

    /**
     * Exits the app
     */
    private function quitApplication()
    {
        print 'Bye bye!'; // Should be in view
        exit(0);
    }
}
