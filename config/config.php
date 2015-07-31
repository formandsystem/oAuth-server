<?php

return [

  'contentTypes' => [
    'application/json' => 'application/vnd.formandsystem.oauth.v1+json',
    'application/vnd.formandsystem.oauth+json' => 'application/vnd.formandsystem.oauth.v1+json',
    'application/vnd.formandsystem.oauth.v1+json' => 'application/vnd.formandsystem.oauth.v1+json'
  ],

  'allowOrigin' => [
    'http://formandsystem.com'
  ],

  'scopes' => [
    'client' => [
      'read' => 'client.read',
      'create' => 'client.create',
      'update' => 'client.update',
      'delete' => 'client.delete'
    ]
  ]

];
