<?php

namespace Registry\Views;

use Exception;

class MenuView extends CommandLineView
{
    /**
     * Command line options
     * @var array of 'option' => 'description'
     */
    private $options;

    /**
     * @param array $options 'option' => 'description'
     * @param string $header Optional header text to be printed
     */
    public function __construct($options, $header = "")
    {
        $this->options = $options;

        if ($header != "") {
            print($header);
        }
    }

    public function readMenuOption($prompt = "Please select menu option:")
    {
        while (true) {
            $this->showMenu($prompt);
            try {
                return $this->readOption('Select option: ');
            } catch (Exception $e) {
                print "Your selected option is not valid, please try again.\n";
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
            throw new Exception();
        }
    }

    /**
     * Show all menu options
     * @param String $prompt Message shown before menu options
     */
    private function showMenu($prompt)
    {
        print "\n\n\n$prompt\n\n";
        foreach ($this->options as $command => $description) {
            print "\t$command : $description\n";
        }
    }
}
