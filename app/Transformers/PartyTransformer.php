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
use App\Transformers\Contracts\TransformerInterface;
use League\Fractal\TransformerAbstract;

class PartyTransformer extends TransformerAbstract implements TransformerInterface
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
            'establishment_date' => ($data->establishment_date) ? timestamp($data->establishment_date) : null,
            'establishment_approval_date' => ($data->establishment_approval_date) ? timestamp($data->establishment_approval_date) : null,
            'registration_application_date' => ($data->registration_application_date) ? timestamp($data->registration_application_date) : null,
            'registration_approval_date' => ($data->registration_approval_date) ? timestamp($data->registration_approval_date) : null,
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