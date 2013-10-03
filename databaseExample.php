#!/usr/bin/env php -q
<?php
require('./vendor/autoload.php');

// Dependancies
use Registry\Models\ServiceModel;
use Registry\Models\MemberModel;
use Registry\Models\BoatModel;
use Registry\Models\BoatTypeModel as BoatType;

// Initialze database

// Create temporary database (lasts as long as the program is running)
$db = new PDO('sqlite::memory:');

// Create a database in a file
//$db = new PDO('sqlite:database/registry.sqlite');

// This object does everything with the database.
// It's pretty short and documented - No need to look at the StorageModels
$service = new ServiceModel($db);

// Test database

// Add members
$jamie = new MemberModel(5, 'The Kingslayer', '123456-1234');
$cersei = new MemberModel(7, 'Cersei Lannister', '654321-0987');
$sansa = new MemberModel(2, 'Sansa Stark', '354321-0487');
$service->addMember($jamie);
$service->addMember($cersei);
$service->addMember($sansa);

// Change members
$jamie->setName('Jamie Lannister');
$service->changeMember($jamie);

// Select members
$service->getMember(5);
$service->getMember(7);

// Delete members
$service->removeMember(2); // Goodbye Sansa!

// List members
$allMembers = $service->getMembers();

// Add boats
$boat1 = new BoatModel(3, BoatType::SAILBOAT, 7.5);
$boat2 = new BoatModel(5, BoatType::MOTORBOAT, 5);
$boat3 = new BoatModel(7, BoatType::CANOE, 3);
$service->addBoat($boat1, 7); // Both belong to Cersei
$service->addBoat($boat2, 7);
$service->addBoat($boat3); // This one has no owner

// Change boat
$boat2->setLength(11.3);
$service->changeBoat($boat2);

// Change owner of boat
$service->changeBoat($boat2, $jamie->getMemberID()); // Now belongs to Jamie

// Select boats
$jamiesBoats = $service->getBoats($jamie->getMemberID());
$allBoats = $service->getBoats();
$sailBoat = $service->getBoat(3);

// Delete boats
$service->removeBoat($sailBoat);
var_dump($service->getBoats());












