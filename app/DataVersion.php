<?php

namespace App;

use Illuminate\Filesystem\Filesystem;

/**
 * Import Data Version Handler.
 * 
 * @author Nyan Lynn Htut <naynlynnhtut@hexcores.com>
 */
class DataVersion
{
    /**
     * Filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Current version lists.
     *
     * @var array
     */
    protected $currents = [];

    /**
     * Create new DataVersion instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Get current version for given data key.
     *
     * @param  string $key
     * @return int
     */
    public function current($key)
    {
        if ( empty($this->currents)) {
            $this->loadVersion();
        }

        $default = $this->getInitialVersion();

        return isset($this->currents[$key]) ? $this->currents[$key] : $default;
    }

    /**
     * Increment current version for given data key.
     *
     * @param  string $key
     * @param  int $increment Integer value of increment amount. Default is 1
     * @return int
     */
    public function increment($key, $increment = 1)
    {
        if ( empty($this->currents)) {
            $this->loadVersion();
        }

        if ( isset($this->currents[$key])) {
            $version = (int) $this->currents[$key] + $increment;
        } else {
            $version = $this->getInitialVersion() + $increment;
        }

        $this->currents[$key] = $version;

        $this->filesystem->put($this->getVersionFilePath(), json_encode($this->currents));

        return $version;
    }

    /**
     * Load version data from the storage.
     *
     * @return void
     */
    protected function loadVersion()
    {
        $file = $this->getVersionFilePath();

        $versions = [];

        if ( $this->filesystem->exists($file)) {
            $versions = json_decode($this->filesystem->get($file), true);
        }

        $this->currents = $versions;
    }

    /**
     * Get version storage file path.
     *
     * @return string
     */
    protected function getVersionFilePath()
    {
        return storage_path('dataversion');
    }

    /**
     * Get initial version number.
     * This value is used if storage is not have.
     *
     * @return int
     */
    protected function getInitialVersion()
    {
        return (int) env('DATA_VERSION', 0);
    }
}