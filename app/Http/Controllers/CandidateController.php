<?php
/**
 * This file is part of candidate project
 * 
 * @package App\Http\Controllers
 * @author Yan Naing <yannaing@hexcores.com>
 * Date: 7/9/15
 * Time: 6:06 PM
 */

namespace App\Http\Controllers;

use App\Model\Candidate;
use App\Transformers\CandidateTransformer;

class CandidateController extends Controller
{
    /**
     * Get single candidate
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        $data = (new Candidate())->find($id);

        $item = $this->transform($data, new CandidateTransformer(), false);

        return response_ok($item);
    }

    /**
     * Get candidate list
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function candidateList()
    {
        $data = $this->transform($this->query(), new CandidateTransformer(), true);

        return response_ok($data);
    }

    protected function query()
    {
        $model = new Candidate();

        // Filter gender
        if ($gender = app('request')->input('gender'))
        {
            $model = $model->where('gender', strtolower($gender));
        }

        // Filter religion
        if ($religion = app('request')->input('religion'))
        {
            $model = $model->where('religion', ucfirst($religion));
        }

        // Filter legislature
        if ($legislature = app('request')->input('legislature'))
        {
            $model = $model->where('legislature', $legislature);
        }

        // Filter party
        if ($party = app('request')->input('party'))
        {
            $model = $model->where('party_id', $party);
        }

        return $model->paginate();
    }
}