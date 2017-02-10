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

use MongoDate;
use Carbon\Carbon;
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
        $data = (new Candidate())->getBy('candidate_id', $id);
        //$data = (new Candidate())->find($id);

        if (!$data) {
            return response_missing();
        }

        $item = $this->transform($data, new CandidateTransformer($this->getRequestFields(app('request'))), false);

        return response_ok($item);
    }

    /**
     * Get candidate list
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function candidateList($year='2015')
    {
        $fields = $this->getRequestFields(app('request'));

        $data = $this->transform($this->query($fields, $year), new CandidateTransformer($fields), true);

        return response_ok($data);
    }

    /**
     * Search Candidate by Name
     *
     * @return void
     * @author 
     **/
    public function search($year='2015')
    {
        if (!app('request')->has('q')) {

            return response_missing();
            
        }

        $q = app('request')->input('q');
        $fields = $this->getRequestFields(app('request'));

        $model = new Candidate();

        $model = $model->like('name', $q);

        if ($year == '2017') {
            $model = $model->where('election', '2017ByElection');
        } else {
            $model = $model->where('election', '2015GeneralElection');
        }

        $result = $model->paginate($fields);

        $data = $this->transform($result, new CandidateTransformer($fields), true);

        return response_ok($data);
    }

    protected function query($fields = [], $year = '2015')
    {
        $request = app('request');

        $model = new Candidate();

        // Filter gender
        if ($gender = $request->input('gender')) {
            $model = $model->where('gender', strtoupper($gender));
        }

        // Filter religion
        /*if ($religion = $request->input('religion'))
        {
            $model = $model->where('religion', $religion);
        }*/

        // Filter legislature
        if ($legislature = $request->input('legislature')) {
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
        if ($party = $request->input('party')) {
            $model = $model->where('party_id', (int) $party);
        }

        // Filter by CONSTITUENCY ST_PCODE 
        if ($con_st_pcode = $request->input('constituency_st_pcode')) {
            $model = $model->where('constituency.ST_PCODE', $con_st_pcode);
        }

        // Filter by CONSTITUENCY DT_PCODE 
        if ($con_dt_pcode = $request->input('constituency_dt_pcode')) {
            $model = $model->where('constituency.DT_PCODE', $con_dt_pcode);
        }

        // Filter by CONSTITUENCY TS_PCODE 
        if ($con_ts_pcode = $request->input('constituency_ts_pcode')) {
            $model = $model->where('constituency.TS_PCODE', $con_ts_pcode);
        }

        //Filter by CONSTITUENCY AM_PCODE
        if ($con_am_pcode = $request->input('constituency_am_pcode')) {
            $model = $model->where('constituency.AM_PCODE', $con_am_pcode);
        }

        //Filter by CONSTITUENCY_NAME
        if ($con_name = $request->input('constituency_name')) {
            $model = $model->where('constituency.name', $con_name);
        }

        //Filter by CONSTITUENCY_NUMBER
        if ($request->has('constituency_number')) {
            $con_num = $request->input('constituency_number');
            $model = $model->where('constituency.number', (int)$con_num);
        }

        //Filter by CONSTITUENCY_PARENT
        if ($con_parent = $request->input('constituency_parent')) {
            $model = $model->where('constituency.parent', $con_parent);
        }

        // Filter by BirthDate
        if ($request->has('bd_from') && $request->has('bd_to')) {
            $from = $this->asMongoDate($request->input('bd_from'));
            $to = $this->asMongoDate($request->input('bd_to'));

            if ( ! is_null($from) || ! is_null($to)) {
                $model = $model->where('birthdate', [
                    '$gte' => $from, 
                    '$lte' => $to
                ]);
            }
        }

        if ($con_parent = $request->input('constituency_parent')) {
            $model = $model->where('constituency.parent', $con_parent);
        }

        //Filter by Votes (Temp)
        $votes = (int)$request->input('votes');
        if ($votes === -1) {
            $model = $model->where('votes', -1);
        } else if ($votes === 1) {
            $model = $model->where('votes', '!=', -1);
        }

        //Filter by Election Year
        if ($year == '2017') {
            $model = $model->where('election', '2017ByElection');
        } else {
            $model = $model->where('election', '2015GeneralElection');
        }

        // Filter by Residency ST_PCODE 
        /*if ($res_st_pcode = $request->input('residency_st_pcode')) {
            $model = $model->where('residency.ST_PCODE', $res_st_pcode);
        }*/

        // Filter by Residency DT_PCODE 
        /*if ($res_dt_pcode = $request->input('residency_dt_pcode')) {
            $model = $model->where('residency.DT_PCODE', $res_dt_pcode);
        }*/

        if (!empty($fields)) {
            $fields = array_merge(['candidate_id'], $fields);
        }

        return $model->paginate($fields);
    }

    /**
     * Convert given date value to MongoDate instance.
     *
     * @param  string $value Format is Y-m-d
     * @return \MongoDate
     */
    protected function asMongoDate($value)
    {
        if (is_numeric($value)) {
            $value = Carbon::createFromTimestamp($value);
        } elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value)) {
            $value = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        }

        if ( $value instanceof Carbon) {
            return new MongoDate($value->getTimestamp());
        }

        return null;
    }

    /**
     * Get response fields lists from request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function getRequestFields($request)
    {
        if ( ! $request->has('fields')) {
            return [];
        }

        return explode(',', $request->input('fields'));
    }
}