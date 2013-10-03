<?php

namespace Registry\Views;

use Exception;

class MainMenuView extends CommandLineView
{
    private static $options = array(
        'l' => 'List all members',
        'L' => 'List all members (long)',
        'r' => 'Register new member',
        'e' => 'Edit member',
        's' => 'Select member'
    );

    public function __construct()
    {
        //code...
    }

    public function readMenu()
    {
        while (true) {
            $this->showMenu();
            try {
                return $this->readOption('Select option: ');
            } catch (Exception $e) {
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
        if (array_key_exists($option, self::$options)) {
            return $option;
        } else {
            throw new Exception();
        }
    }

    /**
     * Show all menu options
     */
    private function showMenu()
    {
        foreach (self::$options as $command => $description) {
            print "$command : $description\n";
        }
    }
}
