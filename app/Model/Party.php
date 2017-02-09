<?php
/**
 * This file is part of candidate project
 *
 * @package App\Model
 * @author Yan Naing <yannaing@hexcores.com>
 * Date: 7/14/15
 * Time: 1:26 PM
 */

namespace App\Model;


class Party extends AbstractModel
{

    /**
     * @return string
     */
    public function getCollectionName()
    {
        return 'party';
    }

    public static function getPartyidByName($name)
    {
    	$inc = new static;

    	$result = $inc->where('party_name', $name)->get();

    	if ($result) {
    		return (string)$result[0]->_id;
    	}

    	return false;
    }

    public static function getStaticPartyIdByName($name)
    {
        $inc = new static;

        $result = $inc->where('party_name', $name)->get();

        if ($result) {
            return (string)$result[0]->id;
        }

        return false;
    }
}