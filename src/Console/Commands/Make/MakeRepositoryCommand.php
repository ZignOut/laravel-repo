<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends GeneratorCommand
{
    /**
     * The signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name : The name of the Repository}';

    /**
     * The name of the console command.
     * 
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model repository';

    /**
     * Execute the console command.
     * 
     * @return bool/null
     */
    public function handle()
    {

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        $providerPath = app_path('Providers/RepositoryServiceProvider.php');
        $search = '//newline';
        $replace = '$this->app->bind(' . $this->argument('name') . 'RepositoryInterface::class, ' . $this->argument('name') . 'Repository::class);'.PHP_EOL.'        //newline';

        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ((!$this->hasOption('force') ||
                !$this->option('force')) &&
            $this->alreadyExists($this->getNameInput())
        ) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $this->info($this->type . ' created successfully.');
        $this->call('make:repository:interface', [
            'name' => $this->argument('name'),
        ]);

        file_put_contents($providerPath, str_replace($search, $replace, file_get_contents($providerPath)));
    }

    /**
     * build the repository with the given name.
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
        return $rootNamespace . '\Eloquent';
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

        return app_path('/Repository') . str_replace('\\', '/', $name) . 'Repository.php';
    }

    /**
     * Get the stub file for Generator
     * 
     * @return string
     */
    protected function getStub()
    {
        return 'stubs/repository.stub';
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