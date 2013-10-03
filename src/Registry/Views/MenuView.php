<?php

namespace Registry\Views;

use Exception;

class MenuView extends CommandLineView
{

    /**
     * @param array $options 'option' => 'description'
     */
    public function __construct($options)
    {
        // TODO: Validate
        $this->options = $options;
    }

    public function readMenuOption()
    {
        while (true) {
            $this->showMenu();
            try {
                return $this->readOption('Select option: ');
            } catch (Exception $e) {
                print "That is not a valid option\n";
                continue;
            }
        }
    }

    /**
     * Read option from command prompt
     * @param string $prompt
     * @return string option
     */
    private function readOption($prompt = '')
    {
        $option = $this->readLine();
        if (array_key_exists($option, $this->options)) {
            return $option;
        } else {
            print "That is not a valid option.\n";
            throw new Exception();
        }
    }

    /**
     * Show all menu options
     */
    private function showMenu()
    {
        print "\nPlease select menu option:\n";
        foreach ($this->options as $command => $description) {
            print "$command : $description\n";
        }
    }
}
