#!/usr/bin/env php -q
<?php
/**
 * This file is meant to test and demonstrate use of the database with working examples.
 */
require('./vendor/autoload.php');

// Dependancies
use Registry\Models\ServiceModel;
use Registry\Models\MemberModel;
use Registry\Models\BoatModel;
use Registry\Models\BoatTypeModel as BoatType;

/**
 * Initialzing the database
 */

// Create temporary database
// Lasts as long as the program is running, no persistance.
// Great for testing
$db = new PDO('sqlite::memory:');

// Create a database in a file
// This is what we will do in the final product.
// NOTE: The folder must exist for this to work.
//$db = new PDO('sqlite:database/registry.sqlite');

// This object does everything with the database.
// It's pretty short and documented - No need to look at the StorageModels
$service = new ServiceModel($db);

/**
 * Using the database
 */

// Add members
$jamie = new MemberModel(1, 'The Kingslayer', '123456-1234');
$cersei = new MemberModel(2, 'Cersei Lannister', '654321-0987');
$sansa = new MemberModel(3, 'Sansa Stark', '354321-0487');
$service->addMember($jamie);
$service->addMember($cersei);
$service->addMember($sansa);

// Change members
$jamie->setName('Jamie Lannister');
$service->changeMember($jamie);

// Select members
$service->getMember(1); // returns Jamie
$service->getMember(2); // returns Cersei

// Delete members
$service->removeMember($sansa); // Goodbye Sansa!

// List members
$allMembers = $service->getMembers();

// Add boats
$sailBoat = new BoatModel(1, BoatType::SAILBOAT, 7.5);
$motorBoat = new BoatModel(2, BoatType::MOTORBOAT, 5);
$canoe = new BoatModel(3, BoatType::Canoe(), 3); // BoatModel can handle both of these methods of choosing BoatType
$service->addBoat($sailBoat, $cersei); // Both belong to Cersei
$service->addBoat($motorBoat, $cersei);
$service->addBoat($canoe); // This one has no owner

// Change boat
$motorBoat->setLength(11.3);
$service->changeBoat($motorBoat);

// Change owner of boat
$service->changeBoatOwner($canoe, $jamie); // Now belongs to Jamie

// Select boats
$cerseisBoats = $service->getBoats($cersei);
$allBoats = $service->getBoats();
$sailBoat = $service->getBoat(1);

// Delete boats
$service->removeBoat($sailBoat);

// Get member with her boats
$cersei = $service->getMemberWithBoats(2);

// Get boats for a member
$jamiesBoats = $service->getBoats($jamie);
$jamie->setOwnedBoats($jamiesBoats);

// List all members with their boats
$allMembersWithBoats = $service->getMembersWithBoats();
