<?php
/**
 * Clients Table Seeder
 *
 * @package   lucadegasperi/oauth2-server-laravel
 * @author    Luca Degasperi <luca@lucadegasperi.com>
 * @copyright Copyright (c) Luca Degasperi
 * @licence   http://mit-license.org/
 * @link      https://github.com/lucadegasperi/oauth2-server-laravel
 */


use Carbon\Carbon;
use Illuminate\Database\Seeder;

class Testing_ClientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('oauth_clients')->delete();

        $datetime = Carbon::now();

        $clients = [
            [
                'id' => 'test_client_id',
                'secret' => 'test_client_secret',
                'name' => 'test_client_name',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => 'test_cms_id',
                'secret' => 'test_cms_secret',
                'name' => 'test_cms_name',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]
        ];

        DB::table('oauth_clients')->insert($clients);
    }
}
