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
     * [getMember description]
     * @param  int $memberId
     * @return bool
     */
    public function getMember($memberId)
    {
        return $this->members->select($memberId);
    }
}
