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

    protected $dates = ['birthdate'];

    protected $fields = [];

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function transform($data)
    {
        if ( ! empty($this->fields)) {
            return $this->transformFieldOnly($this->fields, $data);
        }

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

    protected function transformFieldOnly($fields, $data)
    {
        $result = [];

        foreach ($fields as $f) {
            if ( in_array($f, $this->dates)) {
                $result[$f] = timestamp($data->{$f});
            } else {
                $result[$f] = $data->{$f};
            }
        }

        return $result;
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