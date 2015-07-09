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


use App\Model\Candidate;
use App\Transformers\Contracts\TransformerInterface;
use League\Fractal\TransformerAbstract;

class CandidateTransformer extends TransformerAbstract implements TransformerInterface
{
    public function transform($data)
    {

        return [
            'id'                => (string)$data->_id,
            'name'              => $data->name,
            'legislature'       => $data->legislature,
            'national_id'       => $data->nrc,
            'birthdate'         => $data->dob,
            'education'         => $data->education,
            'occupation'        => $data->occupation,
            'nationality_religion'  => $data->religion,
            'residency'         => $this->makeResidency(),
            'constituency'      => $this->makeConstituency(),
            'party'             => $this->makeParty(),
            'mother'            => $data->mother,
            'father'            => $data->father
        ];
    }

    public function makeResidency()
    {
        return null;
    }

    protected function makeConstituency()
    {
        return null;
    }

    protected function makeParty()
    {
        return null;
    }
}