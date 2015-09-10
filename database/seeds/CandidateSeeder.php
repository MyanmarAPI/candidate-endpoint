<?php
/**
 * This file is part of candidate project
 *
 * @package Database\seeds
 * @author Yan Naing <yannaing@hexcores.com>
 * Date: 7/14/15
 * Time: 12:20 PM
 */

use App\Model\Candidate;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    public function run()
    {

        $candidate = new Candidate();

        $collection_name = $candidate->getCollectionName();

        $connection = \Hexcores\MongoLite\Connection::instance();

        $connection->collection($collection_name)->drop();

        $faker = Factory::create();

        $parties = mongo_lite('party')->all();

        for ($i = 0; $i < 20; $i++)
        {
            $residency = $faker->state() . ' / ' . $faker->city();
            $constituency = $faker->city() . ' / ' . $faker->cityPrefix() . ' / ' . $faker->state();

            $pcode = $this->getRandomPcode();

            $data = [
                'name'  => $faker->name,
                'gender' => $faker->randomElement(['male', 'female']),
                'legislature'   => $faker->randomElement(['amyotha_hluttaw', 'pyithu_hluttaw', 'region', 'state']),
                'nrc'   => $faker->bothify('##/???(N)######'),
                'dob'   => new \MongoDate($faker->dateTime($max = 'now')->format('U')),
                'education' => $faker->words($nb = rand(0, 4)),
                'occupation'=> $faker->words($nb = rand(0, 4)),
                'religion'  => $faker->randomElement(['Buddhism', 'Christian', 'Islam', 'Hindu']),
                'photo_url' => $faker->imageUrl(400, 400, 'business'),
                'party_id'  => $this->getPartyId($parties),
                'residency' => [
                    'type'  => $residency,
                    'name'  => $residency . ' name',
                    'ST_PCODE' => $pcode['ST_PCODE'],
                    'DT_PCODE' => $pcode['DT_PCODE'],
                    'count' => $faker->randomNumber(5)
                ],
                'constituency'  => [
                    'type'  => $constituency,
                    'name'  => $faker->word(),
                    'ST_PCODE' => $pcode['ST_PCODE'],
                    'DT_PCODE' => $pcode['DT_PCODE'],
                    'count' => $faker->randomNumber(5)
                ],
                'father'    => [
                    'name'      => $faker->name,
                    'religion'  => $faker->randomElement(['Buddhism', 'Christian', 'Islam', 'Hindu'])
                ],
                'mother'    => [
                    'name'      => $faker->name,
                    'religion'  => $faker->randomElement(['Buddhism', 'Christian', 'Islam', 'Hindu'])
                ],
            ];

            $candidate->getCollection()->insert($data);
        }
    }

    protected function getPartyId($parties)
    {
        $party = $parties[rand(0, count($parties)-1)];

        return (string)$party['_id'];
    }

    protected function getRandomPcode()
    {
        $rand_st = rand(1,18);

        $st_num = sprintf("%02d", $rand_st);

        $ST_PCODE = "MMR0".$st_num;

        $DT_PCODE = $ST_PCODE."D001";

        return ['ST_PCODE' => $ST_PCODE, 'DT_PCODE' => $DT_PCODE];
    }
}