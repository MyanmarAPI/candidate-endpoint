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

        if (!$data) {
            return response_missing();
        }

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

    /**
     * Search Candidate by Name
     *
     * @return void
     * @author 
     **/
    public function search()
    {
        if (!app('request')->has('q')) {

            return response_missing();
            
        }

        $q = app('request')->input('q');

        $model = new Candidate();

        $result = $model->like('name', $q)->paginate();

        $data = $this->transform($result, new CandidateTransformer(), true);

        return response_ok($data);
    }

    protected function query()
    {
        $model = new Candidate();

        // Filter gender
        if ($gender = app('request')->input('gender')) {
            $model = $model->where('gender', strtoupper($gender));
        }

        // Filter religion
        /*if ($religion = app('request')->input('religion'))
        {
            $model = $model->where('religion', $religion);
        }*/

        // Filter legislature
        if ($legislature = app('request')->input('legislature')) {
            switch ($legislature) {
                case 'upper_house':
                    $legislature = 'အမျိုးသားလွှတ်တော်';
                    break;
                case 'lower_house':
                    $legislature = 'ပြည်သူ့လွှတ်တော်';
                    break;
                case 'state_region':
                    $legislature = 'တိုင်းဒေသကြီး/ပြည်နယ် လွှတ်တော်';
                    break;
            }
            $model = $model->where('legislature', $legislature);
        }

        // Filter party
        if ($party = app('request')->input('party')) {
            $model = $model->where('party_id', (int) $party);
        }

        // Filter by CONSTITUENCY ST_PCODE 
        if ($con_st_pcode = app('request')->input('constituency_st_pcode')) {
            $model = $model->where('constituency.ST_PCODE', $con_st_pcode);
        }

        // Filter by CONSTITUENCY DT_PCODE 
        if ($con_dt_pcode = app('request')->input('constituency_dt_pcode')) {
            $model = $model->where('constituency.DT_PCODE', $con_dt_pcode);
        }

        // Filter by CONSTITUENCY TS_PCODE 
        if ($con_ts_pcode = app('request')->input('constituency_ts_pcode')) {
            $model = $model->where('constituency.TS_PCODE', $con_ts_pcode);
        }

        //Filter by CONSTITUENCY AM_PCODE
        if ($con_am_pcode = app('request')->input('constituency_am_pcode')) {
            $model = $model->where('constituency.AM_PCODE', $con_am_pcode);
        }

        //Filter by CONSTITUENCY_NAME
        if ($con_name = app('request')->input('constituency_name')) {
            $model = $model->where('constituency.name', $con_name);
        }

        //Filter by CONSTITUENCY_NUMBER
        if ($con_num = app('request')->input('constituency_number')) {
            $model = $model->where('constituency.number', $con_num);
        }

        // Filter by Residency ST_PCODE 
        /*if ($res_st_pcode = app('request')->input('residency_st_pcode')) {
            $model = $model->where('residency.ST_PCODE', $res_st_pcode);
        }*/

        // Filter by Residency DT_PCODE 
        /*if ($res_dt_pcode = app('request')->input('residency_dt_pcode')) {
            $model = $model->where('residency.DT_PCODE', $res_dt_pcode);
        }*/

        return $model->paginate();
    }
}