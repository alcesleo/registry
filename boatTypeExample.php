#!/usr/bin/env php -q
<?php
/**
 * This file is meant to test and demonstrate use of the BoatTypeModel
 */
require('./vendor/autoload.php');

use Registry\Models\BoatTypeModel as BoatType;

$sailBoat = BoatType::sailBoat();

print $sailBoat;
