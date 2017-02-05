<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class UserType extends BaseType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'Users'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The user\'s id'
            ],
            'active' => [
                'type' => Type::boolean(),
            ],
            'first_name' => [
                'type' => Type::string(),
            ],
            'fullname' => [
                'type' => Type::string(),
            ],
            'gravatar' => [
                'type' => Type::string(),
            ],
            'hourly_cost' => [
                'type' => Type::int(),
            ],
            'last_name' => [
                'type' => Type::string(),
            ],
            'mail' => [
                'type' => Type::string(),
            ],
            'username' => [
                'type' => Type::string(),
            ],
            'week_duration' => [
                'type' => Type::int(),
            ],
        ];
    }
}
