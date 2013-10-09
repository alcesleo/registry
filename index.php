#!/usr/bin/env php -q
<?php
require('./config.php');
require('./vendor/autoload.php');

use Registry\Controllers\AppController;

$app = new AppController();
$app->run();
