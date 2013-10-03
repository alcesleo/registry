<?php

namespace Registry\Views;

class CommandLineView
{
    /**
     * Read input from the commandline
     * @param string $prompt
     * @return string entered line
     */
    public function readLine($prompt = '')
    {
        print $prompt;
        return fread(STDIN, 80);
    }
}
