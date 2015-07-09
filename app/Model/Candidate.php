<?php
/**
 * This file is part of candidate project
 * 
 * @package App\Model
 * @author Yan Naing <yannaing@hexcores.com>
 * Date: 7/9/15
 * Time: 6:07 PM
 */

namespace App\Model;


class Candidate extends AbstractModel
{

    /**
     * Return mongo collection name to be connected
     *
     * <code>
     *     public function getCollectionName()
     *     {
     *         return 'user';
     *     }
     * </code>
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'candidate';
    }
}