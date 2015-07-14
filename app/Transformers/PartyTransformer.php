<?php
/**
 * This file is part of candidate project
 *
 * @package App\Transformers
 * @author Yan Naing <yannaing@hexcores.com>
 * Date: 7/14/15
 * Time: 1:26 PM
 */

namespace App\Transformers;


class PartyTransformer
{
    public function transform($data)
    {
        return [
            'name'      => $data->name,
            'name_eng'  => $data->eng_name,
            'members'   => $data->members,
            'leader'    => $data->leader,
            'chairman'  => $data->chairman,
            'founded'   => $data->founded,
            'register'  => $data->register,
            'number'    => $data->number,
            'contact'   => $data->contact,
            'address'   => $data->address,
            'region'    => $data->region,
            'files'     => $data->files
        ];
    }
}