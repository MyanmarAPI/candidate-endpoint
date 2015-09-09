<?php
/**
 * This file is part of candidate project
 *
 * @package App\Iora
 * @author Yan Naing <yannaing@hexcores.com>
 * Date: 7/15/15
 * Time: 1:16 PM
 */

namespace App\Iora;


class PartyReader extends Reader
{
    protected function makeData(array $keys, array $data)
    {
        $result = [];

        foreach ($keys as $index => $value)
        {
            switch ($value) {
                case 'EstablishmentDate':
                case 'EstablishmentApprovalDate':
                case 'RegistrationApplicationDate':
                case 'RegistrationApprovalDate':
                    $result[snake_case($value)] = ($data[$index]) ? new \MongoDate(strtotime($data[$index])) : '';
                    break;
                case 'Chairman':
                case 'Leadership':
                    $result[snake_case($value)] = $this->makeName($data[$index]);
                    break;
                case 'Contact':
                    $result[snake_case($value)] = $this->makePhone($data[$index]);
                    break;
                case 'ST_PCODE':
                    $result[$value] = $data[$index];
                    break;
                case 'DT_PCODE':
                    $result[$value] = $data[$index];
                    break;
                default:
                    $result[snake_case($value)] = $data[$index];

                    break;
            }
        }

        return $result;
    }

    protected function makeName($data)
    {
        return array_map(function($item)
        {
            return preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',$item);

        }, explode('၊', $data));
    }

    protected function makePhone($data)
    {
        return preg_split("/(,|၊)\s+/", $data);

        /*$phones = explode('၊', $data);

        $result = [];

        foreach ($phones as $phone)
        {
            $result[] = preg_replace("/[^0-9]/i", '', $phone);
        }

        return $result;*/
    }
}