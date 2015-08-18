<?php

return [
  /*
  |--------------------------------------------------------------------------
  | Content Types
  |--------------------------------------------------------------------------
  |
  | Available content types for content type negotiation
  |
  */
  'contentTypes' => [
    'application/json'                              => 'application/vnd.formandsystem.oauth.v1+json',
    'application/vnd.formandsystem.oauth+json'      => 'application/vnd.formandsystem.oauth.v1+json',
    'application/vnd.formandsystem.oauth.v1+json'   => 'application/vnd.formandsystem.oauth.v1+json'
  ],
    /*
    |--------------------------------------------------------------------------
    | Default Content Type
    |--------------------------------------------------------------------------
    |
    */
  'contentTypeDefault' => 'application/json',
  /*
  |--------------------------------------------------------------------------
  | Allowed Origin
  |--------------------------------------------------------------------------
  |
  | The origins that are allowed to access the api
  |
  */
  'allowOrigin' => [
    'http://formandsystem.com'
  ],
  /*
  |--------------------------------------------------------------------------
  | Allowed Headers
  |--------------------------------------------------------------------------
  |
  | Those headers will be used for the api responses in the allow headers header
  |
  */
  'allowHeaders' => 'Authorization, Content-Type, Accept',
  /*
  |--------------------------------------------------------------------------
  | Scopes
  |--------------------------------------------------------------------------
  |
  |
  */
  'scopes' => [
    'content' => [
      'read'      => 'content.read',
      'create'    => 'content.create',
      'update'    => 'content.update',
      'delete'    => 'content.delete'
    ],
    'client' => [
      'read'      => 'client.read',
      'create'    => 'client.create',
      'update'    => 'client.update',
      'delete'    => 'client.delete'
    ]
  ]

];
