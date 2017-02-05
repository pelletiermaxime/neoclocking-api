<?php

namespace App\GraphQL\Query;

use App\Models\Task;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;

class TasksQuery extends Query
{
    protected $attributes = [
        'name' => 'tasks',
        'description' => 'Tasks query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Task'));
    }

    public function args()
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'defaultValue' => 25,
                'description' => 'Limit results. Defaults to 25.'
            ],
            'number' => [
                'type' => Type::string(),
                'description' => 'Task number',
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(3);

        $tasksQuery = Task::query();

        if (isset($args['number'])) {
            $tasksQuery->where('number', $args['number']);
        }

        foreach ($fields as $field => $keys) {
            if ($field === 'client') {
                $tasksQuery->with('client');
            }
            if ($field === 'project') {
                $tasksQuery->with('project');
            }
            if ($field === 'milestone') {
                $tasksQuery->with('milestone');
            }
            if ($field === 'log_entries') {
                $tasksQuery->with('log_entries');
            }
            if ($field === 'resource') {
                $tasksQuery->with('resource');
            }
            if ($field === 'reference') {
                $tasksQuery->with('reference');
            }
        }

        return $tasksQuery->paginate($args['limit']);
    }
}
