<?php

namespace AppBundle\Service;


class FlightInfo
{
    /**
     * @var string
     */
    private $unit;

    /**
     * FlightInfo constructor.
     * @param string $unit Defined in config.yml
     */
    public function __construct($unit)
    {
        $this->_unit = $unit;
    }

    /**
     * Distance calculation between latitude/longitude based on Harnive's formula
     * http://www.codecodex.com/wiki/Calculate_Distance_Between_Two_Points_on_a_Globe#PHP
     *
     * @param float $latitudeFrom Departure
     * @param float $longitudeFrom Depature
     * @param float $latitudeTo Arrival
     * @param float $longitudeTo Arrival
     * @return float
     */
    public function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $distance = 0;
        $earth_radius = 6.371;
        $dLat = deg2rad($latitudeTo - $latitudeFrom);
        $dLon = deg2rad($longitudeTo - $longitudeFrom);
        $a = pow(sin($dLat/2),2) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * pow(sin($dLon/2),2);
        $c = 2 * asin(sqrt($a));

        switch ($this->_unit) {
            case 'km':
                $distance = $c * $earth_radius;
                break;
            case 'mi':
                $distance = $c * $earth_radius / 1.609344;
                break;
            case 'nmi':
                $distance = $c * $earth_radius / 1.852;
                break;
        }

        return $distance;
    }

    /**
     * Calculate a flight time with distance and plane cruise speed
     *
     * @param integer $cruiseSpeed Plane's cruise speed
     * @param float $distance Distance between departure and arrival
     *
     * @return float
     */
    public function getTime($cruiseSpeed, $distance)
    {
        return round(($cruiseSpeed * $distance) *60);
    }



}