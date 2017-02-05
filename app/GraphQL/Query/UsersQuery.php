<?php

namespace App\GraphQL\Query;

use App\Models\User;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'Users',
        'description' => 'Users query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'defaultValue' => 25,
                'description' => 'Limit results. Defaults to 25.'
            ],
            'username' => [
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(3);

        $usersQuery = User::query();

        if (isset($args['username'])) {
            $usersQuery->where('username', $args['username']);
        }

        foreach ($fields as $field => $keys) {
            if ($field === 'log_entries') {
                $usersQuery->with('log_entries');
            }
        }

        return $usersQuery->paginate($args['limit']);
    }
}
