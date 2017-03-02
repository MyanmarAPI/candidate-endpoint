<?php
/**
 * This file is part of candidate project
 *
 * @package App\Iora
 * Date: 7/15/15
 * Time: 1:16 PM
 */

namespace App\Iora;

use App\Model\Party;


class CandidateReader extends Reader
{
    protected function makeData(array $keys, array $data)
    {
        $result = [];

        foreach ($keys as $index => $value)
        {
            switch ($value) {
                case 'full_name':
                    $result['name'] = $data[$index];
                    $result['sorting_name'] = $this->getSortingName($data[$index]);
                    break;
                case 'birthdate':
                    $result['birthdate'] = ($data[$index]) ? new \MongoDate(strtotime($data[$index])) : '';
                    break;
                case 'nationality' : 
                    $result['ethnicity'] = $data[$index];
                    break;
                case 'house' : 
                    $result['legislature'] = $data[$index];
                    break;
                case 'constituency_name' : 
                    $result['constituency']['name'] = $data[$index];
                    break;
                case 'constituency_number' : 
                    $result['constituency']['number'] = (int)$data[$index];
                    break;
                case 'state' : 
                    $result['constituency']['parent'] = $data[$index];
                    break;
                case 'ST_PCODE' :
                    $result['constituency']['ST_PCODE'] = $data[$index];
                    break;
                case 'DT_PCODE' :
                    $result['constituency']['DT_PCODE'] = (empty($data[$index])) ? null : $data[$index];
                    break;
                case 'TS_PCODE' :
                    $result['constituency']['TS_PCODE'] = (empty($data[$index])) ? null : $data[$index];
                    break;
                case 'AM_PCODE' :
                    $result['constituency']['AM_PCODE'] = (empty($data[$index])) ? null : $data[$index];
                    break;
                case 'party' : 
                    //Get static ID
                    $result['party_id'] = $this->getPartyID($data[$index]);
                    break;
                /*case 'occupation' :
                case 'education' : 
                    $result[$value] = $this->makeName($data[$index]);
                    break;*/
                case 'voter_list_number' : 
                    $result['residency']['voter_count'] = $data[$index];
                    break;
                case 'father' :
                    $result['father']['name'] = $data[$index];
                    break;
                case 'father_nationality' :
                    $result['father']['ethnicity'] = $data[$index];
                    break;
                case 'father_religion' :
                     $result['father']['religion'] = $data[$index];
                    break;
                case 'mother' : 
                    $result['mother']['name'] = $data[$index];
                    break;
                case 'mother_nationality' : 
                    $result['mother']['ethnicity'] = $data[$index];
                    break;
                case 'mother_religion' : 
                    $result['mother']['religion'] = $data[$index];
                    break;
                default:
                    $result[$value] = (empty($data[$index])) ? null : $data[$index];
                    break;
            }
        }

        return $result;
    }

    protected function getPartyID($data)
    {
        $id = Party::getStaticPartyIdByName($data);

        if ($id) {
            return $id;
        }

        return $data;
    }

    protected function makeName($data)
    {
        return array_map(function($item)
        {
            return preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',$item);

        }, explode('၊', $data));
    }

    protected function getSortingName($name) {
        return trim(preg_replace('/^(\ဦး|ဒေါ်|ဒေါက်တာ|Dr.)/','',$name, 1));
    }

}