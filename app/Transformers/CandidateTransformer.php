<?php
/**
 * This file is part of candidate project
 * 
 * @package App\Transformers
 * @author Yan Naing <yannaing@hexcores.com>
 * Date: 7/9/15
 * Time: 6:08 PM
 */

namespace App\Transformers;


use App\Model\Party;
use App\Transformers\Contracts\TransformerInterface;
use League\Fractal\TransformerAbstract;

class CandidateTransformer extends TransformerAbstract implements TransformerInterface
{
    protected $availableIncludes = [
        'party'
    ];

    public function transform($data)
    {
        return [
            'id'                => (string)$data->_id,
            'name'              => $data->name,
            'gender'            => $data->gender,
            'photo_url'         => $data->photo_url,
            'legislature'       => $data->legislature,
            'national_id'       => $data->nrc,
            'birthdate'         => timestamp($data->dob),
            'education'         => $data->education,
            'occupation'        => $data->occupation,
            'nationality_religion'  => $data->religion,
            'residency'         => $data->residency,
            'constituency'      => $data->constituency,
            'party_id'          => $data->party_id,
            'mother'            => $data->mother,
            'father'            => $data->father
        ];
    }

    public function includeParty($data)
    {
        $party = (new Party())->find($data->party_id);

        return $this->item($party, new PartyTransformer());
    }
}