<?php

namespace Registry\Models;

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
    private $boatType;

    /**
     * @return BoatTypeModel
     */
    public static function sailBoat()
    {
        return new BoatTypeModel(BoatTypeModel::SAILBOAT);
    }

    /**
     * @return BoatTypeModel
     */
    public static function motorBoat()
    {
        return new BoatTypeModel(BoatTypeModel::MOTORBOAT);
    }

    /**
     * @return BoatTypeModel
     */
    public static function motorSailBoat()
    {
        return new BoatTypeModel(BoatTypeModel::MOTORSAILBOAT);
    }

    /**
     * @return BoatTypeModel
     */
    public static function canoe()
    {
        return new BoatTypeModel(BoatTypeModel::CANOE);
    }

    /**
     * @return BoatTypeModel
     */
    public static function other()
    {
        return new BoatTypeModel(BoatTypeModel::OTHER);
    }

    /**
     * @param int $boatTypeId one of the constants
     */
    private function __construct($boatType)
    {
        $this->boatType = $boatType;
    }

    /**
     * @return string name of boat-type
     */
    public function __toString()
    {
        return self::$strings[$this->boatType];
    }
}
