<?php
/**
 * This file is part of php-endpoint-bootstrap project
 * 
 * @package App\Console\Commands
 * @author Nyan Lynn Htut <naynlynnhtut@hexcores.com>
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputArgument;

class MongoImportCommand extends Command
{

    protected $name = 'mongo:import';

    protected $description = 'Import mongo collection with json file';

    protected $filesystem;

    /**
     * Constructor method for ImportCommand class
     */
    public function __construct()
    {
        parent::__construct();

        $this->filesystem = app('files');
    }

    /**
     * Fire the command
     */
    public function fire()
    {
        $collection = $this->input->getArgument('name');

        $this->import($collection);
    }

    protected function getFileWithPath($collection)
    {
        if ( strpos($collection, '.json') == false) {
            $filename = $collection . '.json';
        }

        $file = storage_path('data/' . $filename);

        if ( ! $this->filesystem->exists($file)) {
            return $this->error('[ERROR !] File not found - ' . $file);
        }

        return $file;
    }

    /**
     * Run import command with process
     *
     * @param  string $collection
     * @return void
     */
    protected function import($collection)
    {
        $file = $this->getFileWithPath($collection);

        $host = $this->getMongoHost();

        $db = $this->getDatabaseName();

        $this->line('MongoDB Importing to ' . $db);

        $command = 'mongoimport -h '.$host.' -d'.$db;

        $process = new Process($command . ' -c ' . $collection . ' < ' . $file);

        $process->run();

        if ( ! $process->isSuccessful()) {
            $this->error('Error to import collection - ' . $collection);

            throw new \RuntimeException($process->getErrorOutput());
        }

        $this->info('Finish mongo import to database '. $db . ' with collection '. $collection);
    }

    /**
     * Get mongo host and port
     *
     * @return string
     */
    protected function getMongoHost()
    {
        $config = $this->laravel['config'];

        $host = $config->get('mongo_lite.host');
        $port = $config->get('mongo_lite.port');

        return $host . ':' . $port;
    }

    /**
     * Get database name.
     * 
     * @return string
     */
    protected function getDatabaseName()
    {
        return $this->laravel['config']->get('mongo_lite.database');
    }
    
    /**
     * Get command arguments
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Collection json file name to import']
        ];
    }

}