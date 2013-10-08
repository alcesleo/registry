<?php

namespace Registry\Views;

use Registry\Models\MemberModel;

class DeleteMemberView extends CommandLineView
{
    /**
     * @param MemberModel $member
     * @return Boolean
     */
    public function userWantsToDeleteMember(MemberModel $member) 
    {
        print "\n\nAttention: This will delete ". $member->getName() ." and boats registered to this member!\n";
        
        $keepAsking = true;
        while ($keepAsking) {
            $input = $this->readLine("Do you want to delete this member? [Y/N]: ");
            if(strtolower($input) == 'y' OR strtolower($input) == 'n')
                $keepAsking = false;
            else
                print "\n\nYou need to answer Yes(y) or No(n)\n";
        }
        
        return ($input == 'y');
    }  
    
    public function memberDeleted() 
    {
        print "\n\nMember was successfully deleted!\n";
    }  
    
    public function memberNotDeleted() 
    {
        print "\n\nMember was not deleted!\n";
    }   
}