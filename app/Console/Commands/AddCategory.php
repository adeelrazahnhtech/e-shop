<?php

namespace App\Console\Commands;

use App\Mail\RegisterUserEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AddCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the new category';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    
        Category::create([
            'name' => 'schedule'.time(),
        ]);

        $this->info('successfully category!');
       
    }
}
