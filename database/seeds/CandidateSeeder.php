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
        $faker = Factory::create();

        $parties = mongo_lite('party')->all();

        for ($i = 0; $i < 20; $i++)
        {
            $residency = $faker->state() . ' / ' . $faker->city();
            $constituency = $faker->city() . ' / ' . $faker->cityPrefix() . ' / ' . $faker->state();

            $data = [
                'name'  => $faker->name,
                'legislature'   => $faker->randomElement(['Amyotha Hluttaw', 'Pyithu Hluttaw', 'Region', 'State']),
                'nrc'   => $faker->bothify('##/???(N)######'),
                'dob'   => new \MongoDate($faker->dateTime($max = 'now')->format('U')),
                'education' => $faker->words($nb = rand(0, 4)),
                'occupation'=> $faker->words($nb = rand(0, 4)),
                'religion'  => $faker->randomElement(['Buddhism', 'Christian', 'Islam', 'Hindu']),
                'party_id'  => $this->getPartyId($parties),
                'residency' => [
                    'type'  => $residency,
                    'name'  => $residency . ' name',
                    'count' => $faker->randomNumber(5)
                ],
                'constituency'  => [
                    'type'  => $constituency,
                    'name'  => $faker->word(),
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

            $candidate = new Candidate();

            $candidate->getCollection()->insert($data);
        }
    }

    protected function getPartyId($parties)
    {
        $party = $parties[rand(0, count($parties))];

        return (string)$party['_id'];
    }
}