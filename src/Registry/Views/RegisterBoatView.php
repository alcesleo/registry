<?php

namespace Registry\Views;

class RegisterBoatView extends CommandLineView
{

    /**
     * @return string
     */
    public function getBoatLength()
    {
        // TODO: Validation
        while (true) {
            $input = $this->readLine("\n\nEnter boat length: ");
            if ($input == "") {
                print "Length cannot be blank";
            } else {
                return $input;
            }
        }
    }

    public function getBoatType() 
    {
        // TODO: Prob change to an own menu view?
        while (true) {
            $input = $this->readLine("\nAvailable boat types:\n1 Sailboat\n2 Motorboat\n3 Motorsailboat\n4 Canoe\n5 Other\n\nSelect boat type\n");
            //TODO validation
            if ($input == "") {
                print "You must select boat type";
            } else {
                return intval($input);
            }
        }

    }
}
