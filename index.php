#!/usr/bin/env php -q
<?php
require('src/Registry/Views/CommandLineView.php');

use Registry\Views\CommandLineView;

$view = new CommandLineView();
print $view->readLine('Testar: ');
print ("elintestar");
