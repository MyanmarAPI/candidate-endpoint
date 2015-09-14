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
        if ( empty($data)) {
            return [];
        }
        
        return [
            'id'    => $data->id,
            'party_name'      => $data->party_name,
            'party_name_english'  => $data->party_name_english,
            'abbreviation' => $data->abbreviation,
            'member_count'   => $data->member_count,
            'leadership'    => $data->leadership,
            'chairman'  => $data->chairman,
            'establishment_date' => timestamp($data->establishment_date),
            'establishment_approval_date' => timestamp($data->establishment_approval_date),
            'registration_application_date' => timestamp($data->registration_application_date),
            'registration_approval_date' => timestamp($data->registration_approval_date),
            'approved_party_number'    => $data->approved_party_number,
            'party_flag' => $data->party_flag,
            'party_seal' => $data->party_seal,
            'region'    => $data->region,
            'ST_PCODE' => $data->ST_PCODE,
            'DT_PCODE' => $data->DT_PCODE,
            'headquarters'   => $data->headquarters,
            'contact'   => $data->contact,
            'policy'    => $data->policy,
        ];
    }
}