<?php

namespace Registry\Controllers;

use Registry\Controllers\MemberController;
use Registry\Views\MenuView;
use Registry\Views\CompactMemberListView;
use Registry\Views\FullMemberListView;
use Registry\Views\SelectMemberView;
use Registry\Views\DeleteBoatView;
use Registry\Views\BoatMenuView;
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

    /**
     * @var MemberController $memberController
     */
    private $memberController;

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

        $this->memberController = new MemberController($this->serviceModel);

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
                $this->memberController->registerMember();
                break;
            case 'e':
                $this->memberController->editMember();
                break;
            case 'd':
                $this->memberController->deleteMember();
                break;
            case 's':
                $this->memberController->selectSingleMember();
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
    private function deleteBoat(MemberModel $member)
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
