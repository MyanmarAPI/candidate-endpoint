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
            'mpid'              => $data->mpid,
            'gender'            => $data->gender,
            'photo_url'         => $data->photo_url,
            'legislature'       => $data->legislature,
            'birthdate'         => timestamp($data->birthdate),
            'education'         => $data->education,
            'occupation'        => $data->occupation,
            'ethnicity'         => $data->ethnicity,
            'religion'          => $data->religion,
            'ward_village'      => $data->ward_village,
            'constituency'      => $data->constituency,
            'party_id'          => $data->party_id,
            'mother'            => $data->mother,
            'father'            => $data->father
        ];
    }

    public function includeParty($data)
    {
        $party = [];
        $partyId = $data->party_id;

        if ( ! is_null($partyId)) {
            $party = (new Party())->getCollection()->first(['id' => $partyId]);
        }

        return $this->item($party, new PartyTransformer());
    }
}