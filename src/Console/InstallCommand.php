<?php

namespace Marshmallow\ExactOnline\Console;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exactonline:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the exact online tool for nova';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->addScriptsToNpmPackage();
        $this->installNpmDependencies();
        $this->compile();
    }

    /**
     * Add a path repository for the tool to the application's composer.json file.
     *
     * @return void
     */
    protected function addScriptsToNpmPackage()
    {
        $package = json_decode(file_get_contents(base_path('package.json')), true);

        $package['scripts']['build-exact-online'] = 'cd '.$this->relativeToolPath().' && npm run dev';
        $package['scripts']['build-exact-online-prod'] = 'cd '.$this->relativeToolPath().' && npm run prod';

        file_put_contents(
            base_path('package.json'),
            json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    protected function relativeToolPath()
    {
        return str_replace(base_path() . '/', '', $this->toolPath());
    }

    protected function toolPath()
    {
        return str_replace('/src/Console', '', __dir__);
    }

    /**
     * Install the tool's NPM dependencies.
     *
     * @return void
     */
    protected function installNpmDependencies()
    {
        $this->executeCommand('npm set progress=false && npm install', $this->toolPath());
    }

    /**
     * Compile the tool's assets.
     *
     * @return void
     */
    protected function compile()
    {
        $this->executeCommand('npm run dev', $this->toolPath());
    }

    /**
     * Run the given command as a process.
     *
     * @param  string  $command
     * @param  string  $path
     * @return void
     */
    protected function executeCommand($command, $path)
    {
        $process = (new Process($command, $path))->setTimeout(null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $process->setTty(true);
        }

        $process->run(function ($type, $line) {
            $this->output->write($line);
        });
    }
}
