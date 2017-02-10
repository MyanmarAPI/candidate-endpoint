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
use Symfony\Component\Console\Input\InputOption;

class ImportCandidateCommand extends Command
{
    //protected $name = 'import:party {filename}';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:candidate {filename} {--keep}';

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

        // Version Handel
        if ( ! $this->option('keep')) {
            $this->handelDataVersion('candidate');
        }

        $this->info('[SUCCESS] Imported ' . $reader->getRows() . ' rows');
    }

    /**
     * Handel data versioning.
     *
     * @param string $key
     * @return void
     */
    protected function handelDataVersion($key)
    {
        $dataVersion = $this->laravel['data_version'];
        $current = $dataVersion->current($key);
        $new = $dataVersion->increment($key);
        $this->info(sprintf('[Data version] %s is changes from %d to %d', $key, $current, $new));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['keep', 'k', InputOption::VALUE_NONE, 'Keep current version number. Don\'t change.'],
        ];
    }
}