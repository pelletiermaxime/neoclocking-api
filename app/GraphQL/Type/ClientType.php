<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class ClientType extends BaseType
{
    protected $attributes = [
        'name' => 'Client',
        'description' => 'Clients'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the client'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The client name'
            ],
            'number' => [
                'type' => Type::string(),
                'description' => 'The client number'
            ],
        ];
    }
}
