<?php
/**
 * This file is part of php-endpoint-bootstrap project
 * 
 * @package App\Console\Commands
 * @author Nyan Lynn Htut <naynlynnhtut@hexcores.com>
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class DropByElectionYearCommand extends Command
{

    protected $name = 'dropby:election {name} {election}';

    protected $description = 'Drop the collection from database by Election Year';

    /**
     * Fire the command
     */
    public function fire()
    {
        $collection = $this->input->getArgument('name');

        $election = $this->input->getArgument('election');

        $this->info('Drop the collection ' . $collection . ' for '. $election);

        mongo_lite($collection)->delete(['election' => $election]);
    }
    
    /**
     * Get command arguments
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Collection name to drop'],
            ['election', InputArgument::REQUIRED, 'Election Year to drop'] //2015GeneralElection, 2017ByElection
        ];
    }

}