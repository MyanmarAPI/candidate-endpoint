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

use App\Iora\PartyReader;
use Illuminate\Console\Command;

class ImportPartyCommand extends Command
{
    //protected $name = 'import:party {filename}';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:party {filename}';

    protected $description = 'Import all party data from csv file';

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
        $file = storage_path('data/'.$this->argument('filename'));

        if (! $this->filesystem->exists($file))
        {
            return $this->line('[ERROR !] File not found - ' . $file);
        }

        $this->info('Importing party data');

        $reader = new PartyReader($file);

        $reader->model('party')->import();

        $this->info('[SUCCESS] Imported ' . $reader->getRows() . ' rows');
    }
}