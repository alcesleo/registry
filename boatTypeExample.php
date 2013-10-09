#!/usr/bin/env php -q
<?php
/**
 * This file is meant to test and demonstrate use of the BoatTypeModel
 * It is meant to work as much as an Enum as possible
 */
require('./vendor/autoload.php');

use Registry\Models\BoatTypeModel as BoatType;
use Registry\Models\BoatModel;

// Create a type
$sailBoatType = BoatType::SailBoat();
print $sailBoatType . "\n";

// Use it with a boat
$boat = new BoatModel(null, $sailBoatType, 6);
print $boat->getBoatType() . "\n";

// Set boatType with constructor-function
$boat->setBoatType(BoatType::Canoe());
print $boat->getBoatType() . "\n";

// Set boatType with constant
$boat->setBoatTypeByID(BoatType::MOTORSAILBOAT);
print $boat->getBoatType() . "\n";
