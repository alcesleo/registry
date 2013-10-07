<?php

namespace Registry\Models;

use Registry\Models\BoatModel;
use Registry\Models\BoatStorageModel;
use Registry\Models\MemberModel;
use Registry\Models\MemberStorageModel;
use Exception;
use PDO;

/**
 * An interface to the database models. This is here to provide a facade for
 * the database, and make it easy to use them.
 *
 * NOTE: All boolean return values indicate 'true on success, false on failure'
 */
class ServiceModel
{
    /**
     * @var MemberStorageModel
     */
    private $members;

    /**
     * @var BoatStorageModel
     */
    private $boats;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        // Initialize the data access objects
        $this->members = new MemberStorageModel($pdo);
        $this->boats = new BoatStorageModel($pdo);

        // Make sure the tables exist
        $this->members->createTable();
        $this->boats->createTable();
    }

    /**
     * @param MemberModel $member
     */
    public function addMember(MemberModel $member)
    {
        return $this->members->insert($member);
    }

    /**
     * @param  int $memberId
     * @return MemberModel
     */
    public function getMember($memberId)
    {
        return $this->members->select($memberId);
    }

    /**
     * Get all members in database
     * @return MemberModel[]
     */
    public function getMembers()
    {
        return $this->members->selectAll();
    }

    /**
     * Convenience function for getting a member by id, and her owned boats
     * @param  int $memberId
     * @return MemberModel with reference to her boats
     */
    public function getMemberWithBoats($memberId)
    {
        $member = $this->getMember($memberId);
        $boats = $this->getBoats($member);
        $member->setOwnedBoats($boats);
        return $member;
    }

    /**
     * Convenience method for getting all members with their associated boats
     * @return MemberModel[] with references to boats
     */
    public function getMembersWithBoats()
    {
        // Get list of members
        $members = $this->getMembers();

        // Attach boats
        foreach ($members as $member) {
            $boats = $this->getBoats($member);
            $member->setOwnedBoats($boats);
        }

        return $members;
    }

    /**
     * Changes the properties of a member based on its memberId (which will not be changed)
     * @param  MemberModel $member
     * @return bool
     */
    public function changeMember(MemberModel $member)
    {
        return $this->members->update($member);
    }

    /**
     * @param  MemberModel $member
     * @return bool
     */
    public function removeMember(MemberModel $member)
    {
        return $this->members->delete($member->getMemberID());
    }

    /**
     * @param BoatModel    $boat
     * @param MemberModel  $owner optional owner of boat
     */
    public function addBoat(BoatModel $boat, MemberModel $owner = null)
    {
        $ownerId = $owner instanceof MemberModel ? $owner->getMemberID() : null;
        $this->boats->insert($boat, $ownerId);
    }

    /**
     * @param  int $boatId
     * @return BoatModel
     */
    public function getBoat($boatId)
    {
        return $this->boats->select($boatId);
    }

    /**
     * Get boats for selected member, if omitted returns all boats
     * @param  MemberModel $member    optional owner of boats to get
     * @return BoatModel[]            or empty array
     */
    public function getBoats(MemberModel $member = null)
    {
        try {
            if ($member instanceof MemberModel) {
                return $this->boats->selectByMember($member->getMemberID());
            } else {
                return $this->boats->selectAll();
            }
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * @param  BoatModel $boat
     * @return bool
     */
    public function changeBoat(BoatModel $boat)
    {
        return $this->boats->update($boat);
    }

    /**
     * @param  BoatModel   $boat
     * @param  MemberModel $newOwner
     * @return bool
     */
    public function changeBoatOwner(BoatModel $boat, MemberModel $newOwner)
    {
        return $this->boats->updateOwner($boat, $newOwner->getMemberID());
    }

    /**
     * Delete a boat from the database
     * @param  BoatModel $boat
     * @return bool
     */
    public function removeBoat(BoatModel $boat)
    {
        return $this->boats->delete($boat->getBoatID());
    }
}
