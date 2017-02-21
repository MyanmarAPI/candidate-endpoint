<?php
/**
 * This file is part of candidate project
 * 
 * @package App\Http\Controllers
 * @author Li Jia Li <limonster.li@gmail.com>
 * Date: 7/9/15
 * Time: 6:06 PM
 */

namespace App\Http\Controllers;

use MongoDate;
use Carbon\Carbon;
use App\Model\Candidate;
use App\Model\Party;
use App\Transformers\PartyTransformer;

class PartyController extends Controller
{

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

        $party_ids = $this->getPartyIDsByYear($year);

        $q = app('request')->input('q');

        $model = new Party();

        $model = $model->where('id', ['$in' => $party_ids])
                        ->like('party_name', $q)
                        ->paginate();

        $data = $this->transform($model, new PartyTransformer(), true);

        return response_ok($data);

    }

    /**
     * Get Party by Year
     *
     * @return \Symfony\Component\HttpFoundation\Response
     **/
    public function getPartyByYear($year = '2015')
    {

        $party_ids = $this->getPartyIDsByYear($year);

        $party = new Party();

        $result = $party->where("id", ['$in' => $party_ids])
                            ->paginate();

        $data = $this->transform($result, new PartyTransformer(), true);

        return response_ok($data);
    }

    private function getPartyIDsByYear($year) 
    {

        if ($year == '2017') {
            $election = '2017ByElection';
        } else {
            $election = '2015GeneralElection';
        }

        $model = new Candidate();

        return $model->distinct("party_id", ["election" => $election]);

    }

}