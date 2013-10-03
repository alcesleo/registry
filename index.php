#!/usr/bin/env php -q
<?php
require('./vendor/autoload.php');

use Registry\Views\CommandLineView;

$view = new CommandLineView();
print $view->readLine('Testar: ');
