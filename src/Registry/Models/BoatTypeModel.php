<?php

namespace Registry\Models;

use Exception;

class BoatTypeModel
{
    const SAILBOAT = 1;
    const MOTORBOAT = 2;
    const MOTORSAILBOAT = 3;
    const CANOE = 4;
    const OTHER = 5;

    /**
     * String representations of types
     * @var array
     */
    private static $strings = array(
        1 => 'Sailboat',
        2 => 'Motorboat',
        3 => 'Motorsailboat',
        4 => 'Canoe',
        5 => 'Other'
    );

    /**
     * @var int
     */
    private $boatTypeId;


    /**
     * @return Array $options
     */
    public static function getTypes()
    {
        $options = self::$strings;
        return $options;
    }
    
    
    /**
     * @return BoatTypeModel
     */
    public static function SailBoat()
    {
        return new BoatTypeModel(BoatTypeModel::SAILBOAT);
    }

    /**
     * @return BoatTypeModel
     */
    public static function MotorBoat()
    {
        return new BoatTypeModel(BoatTypeModel::MOTORBOAT);
    }

    /**
     * @return BoatTypeModel
     */
    public static function MotorSailBoat()
    {
        return new BoatTypeModel(BoatTypeModel::MOTORSAILBOAT);
    }

    /**
     * @return BoatTypeModel
     */
    public static function Canoe()
    {
        return new BoatTypeModel(BoatTypeModel::CANOE);
    }

    /**
     * @return BoatTypeModel
     */
    public static function Other()
    {
        return new BoatTypeModel(BoatTypeModel::OTHER);
    }

    /**
     * @param int $boatTypeId one of the constants
     */
    public function __construct($boatTypeId)
    {
        if (! array_key_exists($boatTypeId, self::$strings)) {
            throw new Exception("BoatType with ID $boatTypeId does not exist");
        }
        $this->boatTypeId = $boatTypeId;
    }

    /**
     * Get the number representation of the boat-type
     * @return int
     */
    public function getTypeID()
    {
        return $this->boatTypeId;
    }

    /**
     * @return string name of boat-type
     */
    public function __toString()
    {
        return self::$strings[$this->boatTypeId];
    }
}
