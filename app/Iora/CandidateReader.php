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
                    break;
                case 'birthdate':
                    $result['dob'] = ($data[$index]) ? new \MongoDate(strtotime($data[$index])) : '';
                    break;
                case 'photo_file_name' :
                    $result['photo_url'] = $data[$index];
                    break;
                case 'house' : 
                    $result['legislature'] = $data[$index];
                    break;
                case 'state' : 
                    $result['constituency']['state'] = $data[$index];
                    $result['constituency']['ST_PCODE'] = '';
                    $result['constituency']['DT_PCODE'] = '';
                    break;
                case 'constituency_name' : 
                    $result['constituency']['name'] = $data[$index];
                    break;
                case 'constituency_number' : 
                    $result['constituency']['number'] = $data[$index];
                    break;
                case 'party' : 
                    $result['party_id'] = $this->getPartyID($data[$index]);
                    break;
                case 'occupation' :
                case 'education' : 
                    $result[$value] = $this->makeName($data[$index]);
                    break;
                case 'ward_village' : 
                    $result['residency']['name'] = $data[$index];
                    $result['residency']['ST_PCODE'] = '';
                    $result['residency']['DT_PCODE'] = '';
                    break;
                case 'voter_list_number' : 
                    $result['residency']['voter_count'] = $data[$index];
                    break;
                case 'father' :
                    $result['father']['name'] = $data[$index];
                    break;
                case 'father_nationality' :
                    $result['father']['nationality'] = $data[$index];
                    break;
                case 'father_religion' :
                     $result['father']['religion'] = $data[$index];
                    break;
                case 'mother' : 
                    $result['mother']['name'] = $data[$index];
                    break;
                case 'mother_nationality' : 
                    $result['mother']['nationality'] = $data[$index];
                    break;
                case 'mother_religion' : 
                    $result['mother']['religion'] = $data[$index];
                    break;
                default:
                    $result[$value] = $data[$index];
                    break;
            }
        }

        return $result;
    }

    protected function getPartyID($data)
    {
        $id = Party::getPartyidByName($data);

        if ($id) {
            return $id;
        }

        return $data;
    }

    protected function getRandomPcode()
    {
        $rand_st = rand(1,18);

        $st_num = sprintf("%02d", $rand_st);

        $ST_PCODE = "MMR0".$st_num;

        $DT_PCODE = $ST_PCODE."D001";

        return ['ST_PCODE' => $ST_PCODE, 'DT_PCODE' => $DT_PCODE];
    }

    protected function makeName($data)
    {
        return array_map(function($item)
        {
            return preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',$item);

        }, explode('၊', $data));
    }

}