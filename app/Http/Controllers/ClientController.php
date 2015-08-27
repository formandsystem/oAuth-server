<?php

namespace App\Http\Controllers;

use App\ValueObjects\JsonapiData;
use App\ValueObjects\JsonapiError;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class ClientController extends ApiController implements Httpstatuscodes
{
    /*
     * get client options
     */
    public function options()
    {
        header('Access-Control-Allow-Methods: OPTIONS, POST');

        return response(null, self::HTTP_NO_CONTENT);
    }
    /*
     * get a client
     */
    public function show($id)
    {
        // validate request access token
        $validateAccess = $this->hasAccessOrFail(['client.read']);
        // validate request access token
        if ($validateAccess !== true) {
            return response($validateAccess, self::HTTP_UNAUTHORIZED);
        }
        // try to get client from DB
        $client = $this->db->table('oauth_clients')->where('id', $id)->first();
        // check if client exists or fail
        if (count($client) == 0) {
            return response(new JsonapiError([
                'code' => 304,
                'title' => 'Not found',
                'detail' => 'The resource was not found.',
            ]), self::HTTP_NOT_FOUND);
        }
        // return client
        return response(new JsonapiData([
            'id' => $client->id,
            'type' => 'client',
            'attributes' => [
                'id' => $client->id,
                'name' => $client->name,
                'secret' => $client->secret,
            ],
        ]), self::HTTP_OK);
    }
    /*
     * create a client
     */
    public function create()
    {
        // validate request access token
        $validateAccess = $this->hasAccessOrFail(['client.create']);
        // validate request access token
        if ($validateAccess !== true) {
            return response($validateAccess, self::HTTP_UNAUTHORIZED);
        }
        // try to create client
        $clientData = $this->newClient($this->request->input('client_name'));
        // creation failed due to missing name
        if ($clientData === false) {
            return response(new JsonapiError([
                'code' => 300,
                'title' => 'Missing parameter',
                'detail' => 'The parameter "client_name" must be provided.',
            ]), self::HTTP_BAD_REQUEST);
        }

        $this->db->table('oauth_clients')->insertGetId($clientData);

        return response(new JsonapiData([
                'id' => $clientData['id'],
                'type' => 'client',
                'attributes' => [
                    'secret' => $clientData['secret'],
                ],
                'links' => [
                    'self' => url('/client/'.$clientData['id']),
                ],
            ]), self::HTTP_CREATED);
    }
    /*
     * delete a client
     */
    public function delete($id)
    {
        // validate request access token
        $validateAccess = $this->hasAccessOrFail(['client.delete']);
        // validate request access token
        if ($validateAccess !== true) {
            return response($validateAccess, self::HTTP_UNAUTHORIZED);
        }

        if ($this->db->table('oauth_clients')->where('id', $id)->delete() == 0) {
            return response(new JsonapiError([
                'code' => 304,
                'title' => 'Not found',
                'detail' => 'The resource was not found.',
            ]), self::HTTP_NOT_FOUND);
        }

        return response(null, self::HTTP_NO_CONTENT);
    }
    /*
     * update
     */
    public function update($id)
    {
        // validate request access token
        $validateAccess = $this->hasAccessOrFail(['client.update']);
        // validate request access token
        if ($validateAccess !== true) {
            return response($validateAccess, self::HTTP_UNAUTHORIZED);
        }

        $client = $this->db->table('oauth_clients')->where('id', $id)->first();

        if (count($client) == 0) {
            return response(new JsonapiError([
                'code' => 304,
                'title' => 'Not found',
                'detail' => 'The resource was not found.',
            ]), self::HTTP_NOT_FOUND);
        }
    }
    /*
     * create a new client
     */
    public function newClient($name)
    {
        if (strlen(trim($name)) < 2) {
            return false;
        }

        $now = Carbon::now()->toDateTimeString();
        $client = $this->clientCredentials();

        return [
            'id' => $client['id'],
            'secret' => $client['secret'],
            'name' => $name,
            'created_at' => $now,
            'updated_At' => $now,
        ];
    }

    /*
     * create random client id & secret
     */
    public function clientCredentials()
    {
        // Get a whole bunch of random characters from the OS
        $fp = fopen('/dev/urandom', 'rb');
        $entropy = fread($fp, 32);
        fclose($fp);
        // Takes our binary entropy, and concatenates a string which represents the current time to the microsecond
        $entropy .= uniqid(mt_rand(), true);
        // Hash the binary entropy
        $hash = hash('sha512', $entropy);
        // Base62 Encode the hash, resulting in an 86 or 85 character string
        $hash = gmp_strval(gmp_init($hash, 16), 62);

        return [
            'id' => substr($hash, 0, 32),
            'secret' => substr($hash, 32, 48),
        ];
    }
}
