<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class TaskType extends BaseType
{
    protected $attributes = [
        'name' => 'Task',
        'description' => 'Tasks'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the task'
            ],
            'active' => [
                'type' => Type::boolean(),
            ],
            'can_clock' => [
                'type' => Type::boolean(),
            ],
            'estimation' => [
                'type' => Type::int(),
            ],
            'logEntries' => [
                'type' => Type::listOf(GraphQL::type('LogEntry')),
            ],
            'logged_time' => [
                'type' => Type::int(),
            ],
            'milestone' => [
                'type' => GraphQL::type('Milestone'),
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The task name',
            ],
            'number' => [
                'type' => Type::string(),
                'description' => 'The task number',
            ],
            'project' => [
                'type' => GraphQL::type('Project'),
            ],
            'reference_number' => [
                'type' => Type::int(),
            ],
            'require_comments' => [
                'type' => Type::boolean(),
            ],
            'revised_estimation' => [
                'type' => Type::int(),
            ],
        ];
    }
}
