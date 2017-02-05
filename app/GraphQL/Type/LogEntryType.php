<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class LogEntryType extends BaseType
{
    protected $attributes = [
        'name' => 'LogEntry',
        'description' => 'Log entries'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the log entry'
            ],
            'comment' => [
                'type' => Type::string(),
            ],
            'duration' => [
                'type' => Type::int(),
            ],
            'ended_at' => [
                'type' => Type::string(),
            ],
            'hourly_cost' => [
                'type' => Type::int(),
            ],
            'started_at' => [
                'type' => Type::string(),
            ],
            'validated' => [
                'type' => Type::boolean(),
            ],
        ];
    }

    public function resolveDurationField($root, $args)
    {
        return $root->ended_at->diffInMinutes($root->started_at);
    }
}
