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
}