#!/usr/bin/env php -q
<?php
require('CommandLineView.php');

$view = new CommandLineView();
print $view->readLine('Testar: ');
