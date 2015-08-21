<?php
/**
 * Scopes Table Seeder
 *
 * @package   lucadegasperi/oauth2-server-laravel
 * @author    Luca Degasperi <luca@lucadegasperi.com>
 * @copyright Copyright (c) Luca Degasperi
 * @licence   http://mit-license.org/
 * @link      https://github.com/lucadegasperi/oauth2-server-laravel
 */

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class Testing_ScopesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('oauth_scopes')->delete();

        $datetime = Carbon::now();

        $scopes = [
            [
                'id' => 'content.read',
                'description' => 'Read from api',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => 'content.create',
                'description' => 'Post to api',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => 'content.update',
                'description' => 'Update through api',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => 'content.delete',
                'description' => 'Delete through api',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => 'client.read',
                'description' => 'Read client from api',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => 'client.create',
                'description' => 'Post client to api',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => 'client.update',
                'description' => 'Update client through api',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'id' => 'client.delete',
                'description' => 'Delete client through api',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
        ];

        DB::table('oauth_scopes')->insert($scopes);

        DB::table('oauth_client_scopes')->delete();

        $clientScopes = [
            [
                'client_id' => 'test_client_id',
                'scope_id' => 'content.read',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'client_id' => 'test_client_id',
                'scope_id' => 'content.write',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'client_id' => 'test_cms_id',
                'scope_id' => 'client.read',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'client_id' => 'test_cms_id',
                'scope_id' => 'client.update',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'client_id' => 'test_cms_id',
                'scope_id' => 'client.create',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            [
                'client_id' => 'test_cms_id',
                'scope_id' => 'client.delete',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]
        ];

        // DB::table('oauth_client_scopes')->insert($clientScopes);

        // DB::table('oauth_grant_scopes')->delete();
        //
        // $grantScopes = [
        //     [
        //         'grant_id' => 'grant1',
        //         'scope_id' => 'scope1',
        //         'created_at' => $datetime,
        //         'updated_at' => $datetime,
        //     ],
        //     [
        //         'grant_id' => 'grant2',
        //         'scope_id' => 'scope2',
        //         'created_at' => $datetime,
        //         'updated_at' => $datetime,
        //     ],
        // ];
        //
        // DB::table('oauth_grant_scopes')->insert($grantScopes);
    }
}
