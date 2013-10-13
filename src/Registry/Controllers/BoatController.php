<?php

namespace Registry\Controllers;

use Registry\Models\ServiceModel;
use Registry\Models\MemberModel;
use Registry\Models\BoatModel;
use Registry\Views\SelectMemberView;
use Registry\Views\DeleteBoatView;
use Registry\Views\MenuView;
use Registry\Views\RegisterBoatView;
use Registry\Views\SelectBoatView;
use Registry\Views\EditBoatView;

use Exception;

// TODO fix comments and standard
class BoatController 
{
    private $serviceModel;

    public function __construct(ServiceModel $serviceModel) 
    {
        $this->serviceModel = $serviceModel;
    }


    private function showBoatMenu(MemberModel $member) 
    {
        // If the selected member has boats, show edit and delete. 
        if (count($member->getOwnedBoats())>0) {
            $options = array(
                'r' => 'Register boat',
                'e' => 'Edit boat',
                'd' => 'Delete boat'
            );
        } else {
            $options = array(
                'r' => 'Register boat',
            ); 
        }

        $boatMenu = new MenuView($options, "-----------\n Boat menu \n-----------");
        $option = $boatMenu->readMenuOption();
        
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

    public function handleBoats() 
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
}
