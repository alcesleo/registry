<?php

namespace Registry\Controllers;

use Registry\Models\ServiceModel;
use Registry\Models\MemberModel;
use Registry\Views\CompactMemberListView;
use Registry\Views\FullMemberListView;
use Registry\Views\SelectMemberView;
use Registry\Views\RegisterMemberView;
use Registry\Views\EditMemberView;
use Registry\Views\DeleteMemberView;
use Registry\Views\SingleMemberView;

use Exception;

class MemberController 
{
    /**
     * @var ServiceModel $serviceModel
     */
    private $serviceModel;

    /**
     * @param ServiceModel $serviceModel 
     */
    public function __construct(ServiceModel $serviceModel) 
    {
        $this->serviceModel = $serviceModel;
    }

    public function registerMember()
    {
        $registerMemberView = new RegisterMemberView();

        // Get member name
        $newMemberName = $registerMemberView->getMemberName();

        // Get social security number
        $newMemberSSN = $registerMemberView->getMemberSSN($newMemberName);

        // Create and save the member
        try {
            $newMember = new MemberModel(null, $newMemberName, $newMemberSSN);
            $this->serviceModel->addMember($newMember);
        } catch (Exception $ex) {
            print ("Something went wrong: " . $ex->getMessage()); // TODO: should be in a view
        }
    }

    public function editMember()
    {
        $editMemberView = new EditMemberView();
        try {
            $memberArray = $this->serviceModel->getMembers();
            $selectMemberView = new SelectMemberView($memberArray);
            $member = $selectMemberView->getSelectedMember(); // Select the member for edit

            $changedMember = $editMemberView->changeMemberData($member);
            $this->serviceModel->changeMember($changedMember);
        } catch (Exception $ex){
            print("Something went wrong. " . $ex->getMessage()); // TODO: should be in a view
        }
    }

    /**
     * Delete a member from a list of all members
     */
    public function deleteMember()
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

    public function selectSingleMember()
    {
        $memberModelArray = $this->serviceModel->getMembers();
        $selectMemberView = new SelectMemberView($memberModelArray);
        // Get the user you want to delete
        $member = $selectMemberView->getSelectedMember();
        
        $singleMemberView = new SingleMemberView();
        $singleMemberView->printMemberData($member);
    }

    /**
     * Show a list of the members
     * @param  boolean $long long/short format
     */
    public function showMemberList($long = false)
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
            print("Something went wrong. " . $ex->getMessage()); // TODO: should be in a view
        }
    }
}