#!/usr/bin/env php -q
<?php
require('./vendor/autoload.php');

use Registry\Controllers\MasterController;

$ctrl = new MasterController();
$ctrl->run();
