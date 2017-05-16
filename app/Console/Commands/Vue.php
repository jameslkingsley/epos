<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Vue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new Vue component';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $dir = base_path('resources/assets/js/components');
        $path = "$dir/$name.vue";
        $slug = str_slug(snake_case($name));

        if (file_exists($path)) {
            echo 'File already exists.';
            return;
        } else {
            if (!file_exists($dir)) {
                mkdir($dir);
            }
        }

        file_put_contents($path, file_get_contents(__DIR__.'/../Stubs/VueComponent.vue.stub'));

        $script = base_path('resources/assets/js/app.js');

        file_put_contents($script, preg_replace(
            '/\/\/ Components/',
            "// Components\nVue.component('$slug', require('./components/$name.vue'));",
            file_get_contents($script)
        ));

        echo "$name.vue created!";
    }
}
