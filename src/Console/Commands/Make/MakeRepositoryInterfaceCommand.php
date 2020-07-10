<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Illuminate\Support\Str;

class MakeRepositoryInterfaceCommand extends GeneratorCommand
{
    /**
     * The signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository:interface {name : The name of the Repository}';

    /**
     * The name of the console command.
     * 
     * @var string
     */
    protected $name = 'make:repository:interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model repository interface';

    /**
     * build the repository interface with the given name.
     * 
     * @param string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceName($stub, $name)
            ->replaceClass($stub, $name);
    }

    /**
     * Replace Class name and extention name in stub.
     * 
     * @param string $stub
     * @param string $name
     * @return $this
     */
    protected function replaceName(&$stub, $name)
    {
        $class_name = $this->argument('name');
        $stub = str_replace('Dummy', $class_name, $stub);

        return $this;
    }

    /**
     * get a default namespace for Model
     * 
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    /**
     * Get the destination class path.
     * 
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return app_path('/Repository').str_replace('\\', '/', $name) . 'RepositoryInterface.php';
    }

    /**
     * Get the stub file for Generator
     * 
     * @return string
     */
    protected function getStub()
    {
        return 'stubs/repository.interface.stub';
    }

    /**
     * Get rootNamespace for this class.
     * 
     * @return string
     */
    protected function rootNamespace()
    {
        return 'App/Repository';
    }
}