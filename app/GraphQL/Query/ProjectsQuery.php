<?php

namespace App\GraphQL\Query;

use App\Models\Project;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;

class ProjectsQuery extends Query
{
    protected $attributes = [
        'name' => 'projects',
        'description' => 'A query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Project'));
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
                'description' => 'Project number',
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(3);

        $projectsQuery = Project::query();
        $projectsQuery->active();

        if (isset($args['number'])) {
            $projectsQuery->where('number', $args['number']);
        }

        foreach ($fields as $field => $keys) {
            if ($field === 'client') {
                $projectsQuery->with('client');
            }
            if ($field === 'tasks') {
                $projectsQuery->with('tasks');
            }
        }

        return $projectsQuery->paginate($args['limit']);
    }
}
