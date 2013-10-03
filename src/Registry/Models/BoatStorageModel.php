<?php

namespace Registry\Models;

use Registry\Models\BoatModel;
use Exception;
use PDO;

class BoatStorageModel
{
    /**
     * Holds the database-object
     * @var PDO object
     */
    private $pdo;

    // Names in database
    private $tableName = 'Boats';
    private $ownerId = 'MemberID';
    private $boatId = 'BoatID';
    private $boatType = 'BoatType';
    private $boatLength = 'Length';

    /**
     * @param PDO $database
     */
    public function __construct(PDO $database)
    {
        $this->pdo = $database;
        $this->createTable();
    }

    /**
     * Creates the table if it doesn't already exist.
     */
    private function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->tableName
            (
                $this->boatId INTEGER PRIMARY KEY AUTOINCREMENT,
                $this->ownerId INTEGER,
                $this->boatType INTEGER NOT NULL,
                $this->boatLength FLOAT NOT NULL
            )";
        $this->pdo->exec($sql);
    }

    /**
     * Get a boat object by its ID
     * @param  int $id
     * @return BoatModel
     */
    public function select($id)
    {
        // Prepare statment
        $sql = "SELECT * FROM $this->tableName WHERE $this->boatId = :id";
        $stmt = $this->pdo->prepare($sql);

        // http://php.net/manual/en/pdostatement.bindparam.php
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Get data from pdo
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Error handling
        if (! $result) {
            throw new Exception('Boat not found');
        }

        // TODO Break creation into function?
        return new BoatModel(
            intval($result[$this->boatId]),
            intval($result[$this->boatType]),
            floatval($result[$this->boatLength])
        );
    }

    // TODO: Throws docs

    /**
     * Get all boats belonging to a member
     * @param int $memberId
     * @return BoatModel[]
     */
    public function selectByMember($memberId)
    {
        // Prepare statment
        $sql = "SELECT * FROM $this->tableName WHERE $this->ownerId = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $memberId, PDO::PARAM_INT);

        // Get data from pdo
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Error handling
        if (! $result) {
            throw new Exception('No boats found');
        }

        // Create objects
        $boatList = array();
        foreach ($result as $boatData) {
            $boatList[] = new BoatModel(
                intval($boatData[$this->boatId]),
                intval($boatData[$this->boatType]),
                floatval($boatData[$this->boatLength])
            );
        }
        return $boatList;
    }

    /**
     * Get all boats
     * @return BoatModel[]
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
            throw new Exception('No boats found');
        }

        // Create objects
        $boatList = array();
        foreach ($result as $boatData) {
            $boatList[] = new BoatModel(
                intval($boatData[$this->boatId]),
                intval($boatData[$this->boatType]),
                floatval($boatData[$this->boatLength])
            );
        }
        return $boatList;
    }

    /**
     * Insert a boat into the database
     * @param  BoatModel $boat
     * @param int $ownerId owner of the boat
     * @return bool true on success, false on failure
     */
    public function insert(BoatModel $boat, $ownerId = null)
    {
        // TODO: Exception if boat already exists

        // Prepare statement
        $sql = "INSERT INTO $this->tableName
                ($this->ownerId, $this->boatId, $this->boatType, $this->boatLength)
                VALUES (:ownerId, :boatId, :boatType, :boatLength);";

        $stmt = $this->pdo->prepare($sql);

        // Bind values
        $stmt->bindValue(':ownerId', $ownerId, PDO::PARAM_INT); // TODO: This might crash?
        $stmt->bindValue(':boatId', $boat->getBoatID(), PDO::PARAM_INT);
        $stmt->bindValue(':boatType', $boat->getBoatType(), PDO::PARAM_INT);
        $stmt->bindValue(':boatLength', $boat->getLength(), PDO::PARAM_STR); // There is no PARAM_FLOAT :(

        return $stmt->execute();
    }

    /**
     * Update a boat in the database
     * @param  BoatModel $boat The boat to update
     * @return bool true on success, false on failure
     */
    public function update(BoatModel $boat)
    {
        // Prepare statement
        $sql = "UPDATE $this->tableName
                SET $this->boatType = :boatType,
                    $this->boatLength = :boatLength
                WHERE $this->boatId = :boatId;";

        $stmt = $this->pdo->prepare($sql);

        // Bind values
        $stmt->bindValue(':boatType', $boat->getBoatType(), PDO::PARAM_INT);
        $stmt->bindValue(':boatLength', $boat->getLength(), PDO::PARAM_STR); // TODO: strval?
        $stmt->bindValue(':boatId', $boat->getBoatID(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Set owner of a boat
     * @param  BoatModel $boat
     * @param  int $ownerId
     * @return bool
     */
    public function updateOwner(BoatModel $boat, $ownerId)
    {
        // Prepare statement
        $sql = "UPDATE $this->tableName
                SET $this->ownerId = :ownerId
                WHERE $this->boatId = :boatId;";

        $stmt = $this->pdo->prepare($sql);

        // Bind values
        $stmt->bindValue(':ownerId', $ownerId, PDO::PARAM_INT);
        $stmt->bindValue(':boatId', $boat->getBoatID(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Delete a boat
     * @param  int $boatId
     * @return bool true on success, false on failure
     */
    public function delete($boatId)
    {
        $sql = "DELETE FROM $this->tableName
                WHERE $this->boatId = :boatId";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':boatId', $boatId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Delete all boats of a member
     * @param  int $ownerId
     * @return bool true on success, false on failure
     */
    public function deleteForMember($ownerId)
    {
        $sql = "DELETE FROM $this->tableName
                WHERE $this->ownerId = :ownerId";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':ownerId', $ownerId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
