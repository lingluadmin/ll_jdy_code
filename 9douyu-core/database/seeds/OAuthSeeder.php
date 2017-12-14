<?php

use Illuminate\Database\Seeder;

class OAuthSeeder extends Seeder {

    public function run()
    {
        $config = app()->make('config');

        app('db')->table("oauth_clients")->delete();
        app('db')->table('oauth_scopes')->delete();

        app('db')->table("oauth_clients")->insert([
            'id' => $config->get('app.client_id'),
            'secret' => $config->get('app.client_secret'),
            'name' => 'Lumen-Api-Starter'
        ]);
        app('db')->table('oauth_scopes')->insert([
                ['id' => 'public', 'description' => 'scope for swagger'],
        ]);
    }

}