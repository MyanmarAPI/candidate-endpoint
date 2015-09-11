<?php
/**
 * This file is part of candidate project
 *
 * @package App\Console\Commands
 * @author Yan Naing <yannaing@hexcores.com>
 * Date: 7/15/15
 * Time: 12:57 PM
 */

namespace App\Console\Commands;

use App\Iora\CandidateReader;
use Illuminate\Console\Command;

class ImportCandidateCommand extends Command
{
    //protected $name = 'import:party {filename}';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:candidate {filename}';

    protected $description = 'Import all candidate data from csv file';

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
        $this->import();
    }

    protected function import()
    {
        $filename = $this->argument('filename');

        if ( strpos($filename, '.csv') == false) {
            $filename = $filename . '.csv';
        }

        $file = storage_path('data/' . $filename);

        if (! $this->filesystem->exists($file))
        {
            return $this->line('[ERROR !] File not found - ' . $file);
        }

        $this->info('Importing candidate data');

        $reader = new CandidateReader($file);

        $reader->model('candidate')->import();

        $this->info('[SUCCESS] Imported ' . $reader->getRows() . ' rows');
    }
}