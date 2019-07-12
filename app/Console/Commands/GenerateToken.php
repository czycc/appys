<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appys:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成jwt token';

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
        $userId = $this->ask('用户id：');

        $user = User::find($userId);

        if (!$user) {
            return $this->error('用户不存在');
        }

        //30天过期
        $ttl = 30*24*60;

        $this->info(\Auth::guard('api')->setTTL($ttl)->fromUser($user));
    }
}
