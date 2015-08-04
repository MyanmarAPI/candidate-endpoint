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
            'name'      => $data->party_name,
            'name_eng'  => $data->party_name_english,
            'members'   => $data->member_count,
            'leader'    => $data->leadership,
            'chairman'  => $data->chairman,
            'founded'   => [
                'founded'       => timestamp($data->establishment_date),
                'approved'      => timestamp($data->establishment_approval_date)
            ],
            'register'  => [
                'register'  => timestamp($data->registration_application_date),
                'approved'  => timestamp($data->registration_approval_date)
            ],
            'number'    => $data->approved_party_number,
            'contact'   => $data->contact,
            'address'   => $data->headquarters,
            'region'    => $data->region,
            'files'     => [
                'flag'      => $data->party_flag,
                'seal'      => $data->party_seal,
                'policy'    => $data->policy
            ]
        ];
    }
}