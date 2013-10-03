<?php

namespace Registry\Models;

use Registry\Models\BoatModel;
use Registry\Models\BoatStorageModel;
use Registry\Models\MemberModel;
use Registry\Models\MemberStorageModel;
use PDO;

/**
 * An interface to the database models. This is here to provide a facade for
 * the database, and make it easy to use them.
 *
 * NOTE: All boolean return values indicate
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
}
