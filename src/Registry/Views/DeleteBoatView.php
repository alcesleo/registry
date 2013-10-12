<?php

namespace Registry\Views;

use Registry\Models\BoatModel;

class DeleteBoatView extends CommandLineView
{
    /**
     * @param MemberModel $member
     * @return bool
     */
    public function userWantsToDeleteBoat(BoatModel $boat)
    {
        print "\n\nAttention: This will delete ". $boat->getBoatType() ."!\n";

        $keepAsking = true;
        while ($keepAsking) {
            $input = $this->readLine("Do you want to delete this boat? [Y/N]: ");
            if (strtolower($input) == 'y' or strtolower($input) == 'n') {
                $keepAsking = false;
            } else {
                print "\n\nYou need to answer Yes(y) or No(n)\n";
            }
        }

        return (strtolower($input) == 'y');
    }

    /**
     * Success-message
     */
    public function showBoatDeleted()
    {
        print "\n\nBoat was successfully deleted!\n";
    }

    /**
     * Aborted message
     */
    public function showBoatNotDeleted()
    {
        print "\n\nBoat was not deleted!\n";
    }
}
