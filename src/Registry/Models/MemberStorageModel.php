<?php

namespace Registry\Models;

use Registry\Models\MemberModel;
use Exception;
use PDO;

// TODO: Fix standard, fix duplication
class MemberStorageModel
{
    /**
     * Holds the database-object
     * @var PDO object
     */
    private $pdo;

    // Names in database
    private $tableName = 'Member';
    private $memberId = 'MemberID';
    private $memberName = 'Name';
    private $socialNumber = 'SocialSecurityNumber';

    /**
     * @param PDO $database
     */
    public function __construct(PDO $database)
    {
        $this->pdo = $database;
    }

    /**
     * Creates the table if it doesn't already exist.
     */
    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->tableName
            (
                $this->memberId INTEGER PRIMARY KEY AUTOINCREMENT,
                $this->memberName TEXT NOT NULL,
                $this->socialNumber TEXT NOT NULL
            )";
        $this->pdo->exec($sql);
    }

    /**
     * Get a member object by its ID
     * @param  int $id
     * @return MemberModel
     */
    public function select($id)
    {
        // Prepare statment
        $sql = "SELECT * FROM $this->tableName WHERE $this->memberId = :id";
        $stmt = $this->pdo->prepare($sql);

        // http://php.net/manual/en/pdostatement.bindparam.php
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Get data from pdo
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Error handling
        if (! $result) {
            throw new Exception('Member not found');
        }

        return new MemberModel(
            intval($result[$this->memberId]),
            $result[$this->memberName],
            $result[$this->socialNumber]
        );
    }

    /**
     * Get all members
     * @return MemberModel[]
     */
    public function selectAll()
    {
        // Prepare statment
        $sql = "SELECT * FROM $this->tableName";
        $stmt = $this->pdo->prepare($sql);

        // Get data from pdo
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Error handling
        if (! $result) {
            throw new Exception('Member not found');
        }

        // Create objects
        $memberList = array();
        foreach ($result as $memberData) {
            $memberList[] = new MemberModel(
                intval($memberData[$this->memberId]),
                $memberData[$this->memberName],
                $memberData[$this->socialNumber]
            );
        }
        return $memberList;
    }

    /**
     * Insert a member into the database
     * @param  MemberModel $member
     * @return bool true on success, false on failure
     */
    public function insert(MemberModel $member)
    {
        // TODO: Exception if member already exists

        // Prepare statement
        $sql = "INSERT INTO $this->tableName
                ($this->memberId, $this->memberName, $this->socialNumber)
                VALUES (:id, :name, :socialnumber);";

        $stmt = $this->pdo->prepare($sql);

        // Bind values
        $stmt->bindValue(':id', $member->getMemberID(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $member->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':socialnumber', $member->getSocialSecurityNumber(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Update a member in the database
     * @param  MemberModel $member The member to update
     * @return bool true on success, false on failure
     */
    public function update(MemberModel $member)
    {
        // Prepare statement
        $sql = "UPDATE $this->tableName
                SET $this->memberName = :name,
                    $this->socialNumber = :socialnumber
                WHERE $this->memberId = :id;";

        $stmt = $this->pdo->prepare($sql);

        // Bind values
        $stmt->bindValue(':name', $member->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':socialnumber', $member->getSocialSecurityNumber(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $member->getMemberID(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Delete a member
     * @param  int $memberid
     * @return bool true on success, false on failure
     */
    public function delete($memberid)
    {
        $sql = "DELETE FROM $this->tableName
                WHERE $this->memberId = :memberid";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':memberid', $memberid, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
