<?php

namespace App\Http\Controllers;

use App\Http\Respond;
use Carbon\Carbon;
use Illuminate\Http\Request;
use InvalidArgumentException;
use LucaDegasperi\OAuth2Server\Authorizer;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class ClientController extends ApiController implements Httpstatuscodes
{
    protected $clientRepository;

    public function __construct(Respond $respond, Request $request, Authorizer $authorizer)
    {
        parent::__construct($respond, $request, $authorizer);
        $this->db = app('db');
    }

    /*
     * get client options
     */
    public function options()
    {
        header('Access-Control-Allow-Methods: OPTIONS, POST');

        return $this->respond->success(null, self::HTTP_NO_CONTENT);
    }
    /*
     * get a client
     */
    public function show($id)
    {
        try {
            $token = str_replace('Bearer ', '', $this->request->header('authorizer'));

            $this->authorizer->validateAccessToken(false, $token);
            $this->hasScopes(['client.read']);
            $configScopes = config('config.scopes');

            $client = $this->db->table('oauth_clients')->where('id', $id)->first();

            // TODO: replace with hasScope ?
            $scopes = $this->db->table('oauth_client_scopes')->where('client_id', $id)->get();
            foreach ($scopes as $scope) {
                if (in_array($scope->scope_id, $configScopes['client'])) {
                    return $this->respond->error([
                        'description' => 'You are not allowed to view this user.',
                        'code' => 106,
                    ], self::FORBIDDEN);
                }
            }

            return $this->respond->success(['data' => [
                'id' => $client->id,
                'type' => 'client',
                'attribtues' => [
                    'id' => $client->id,
                    'name' => $client->name,
                    'secret' => $client->secret,
                ],
            ]], self::HTTP_OK);
        } catch (\Exception $e) {
            return $this->catchException($e);
        }
    }
    /*
     * create a client
     */
    public function create()
    {
        try {
            $token = str_replace('Bearer ', '', $this->request->header('authorization'));
            $this->authorizer->validateAccessToken(true, $token);
            $this->hasScopes(['client.create']);

            $clientData = $this->newClient($this->request->input('client_name'));

            $this->db->table('oauth_clients')->insert($clientData);

            return $this->respond->success(['data' => [
                    'id' => $clientData['id'],
                    'type' => 'client',
                    'attributes' => [
                        'secret' => $clientData['secret'],
                    ],
                    'links' => [
                        'self' => url('/client/'.$clientData['id']),
                    ],
                ],
            ], self::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->catchException($e);
        }
    }
    /*
     * delete a client
     */
    public function delete($id)
    {
        try {
            $token = str_replace('Bearer ', '', $this->request->header('authorization'));
            $this->authorizer->validateAccessToken(true, $token);

            $this->hasScopes(['client.delete']);
            // TODO: add 404 if does not exist
            $this->db->table('oauth_clients')->where('id', $id)->delete();

            return $this->respond->success(null, self::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->catchException($e);
        }
    }

    /*
     * create a new client
     */
    public function newClient($name)
    {
        if (strlen(trim($name)) < 2) {
            throw new InvalidArgumentException('Client name must be at least 2 Characters long.');
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
