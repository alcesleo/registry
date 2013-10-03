#!/usr/bin/env php -q
<?php
require('./vendor/autoload.php');

// Dependancies
use Registry\Models\ServiceModel;
use Registry\Models\MemberModel;

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
$member1 = new MemberModel(5, 'Jamie Lannister', '123456-1234');
$member2 = new MemberModel(7, 'Cersei Lannister', '654321-0987');
$service->addMember($member1);
$service->addMember($member2);

// Change members
$member1->setName('Sansa Stark');
$service->changeMember($member1);

// Select members
var_dump($service->getMember(5));
var_dump($service->getMember(7));

// Delete members
$service->removeMember(5);

// List members
var_dump($service->getMembers()); // All members





