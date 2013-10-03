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
        $this->members = new MemberStorageModel($pdo);
        $this->boats = new BoatStorageModel($pdo);
    }

    /*********************************************
    Members
    **********************************************/

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
     * [getMemberWithBoats description]
     * @param  int $memberId
     * @return MemberObject with reference to her boats
     */
    public function getMemberWithBoats($memberId)
    {
        /*
        $member = $this->getMember($memberId);
        $boats = $this->getBoats($memberId);
        $member->setOwnedBoats($boats);
        return $member;
        */
    }

    /**
     * Changes the properties of a member based on its memberId (which will not be changed)
     * @param  MemberModel $member
     * @return bool
     */
    public function changeMember($member)
    {
        return $this->members->update($member);
    }

    /**
     * @param  int $memberId
     * @return bool
     */
    public function removeMember($memberId)
    {
        return $this->members->delete($memberId);
    }

    /*********************************************
    Boats
    **********************************************/

    /**
     * @param BoatModel $boat
     * @param int    $ownerId
     */
    public function addBoat(BoatModel $boat, $ownerId = null)
    {
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
     * @param  int $memberId optional memberId of boats to get
     * @return BoatModel[]            or empty array
     */
    public function getBoats($memberId = null)
    {
        try {
            if ($memberId !== null) {
                return $this->boats->selectByMember($memberId);
            } else {
                return $this->boats->selectAll();
            }
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Change a boat and its owner (the boatId will not be changed)
     * @param  BoatModel $boat
     * @param  int       $ownerId
     * @return bool
     */
    public function changeBoat(BoatModel $boat, $ownerId = null)
    {
        // NOTE: Should handle rollbacks etc... Really not within time constraints
        if ($ownerId !== null) {
            $this->boats->updateOwner($boat, $ownerId);
        }
        return $this->boats->update($boat);
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
