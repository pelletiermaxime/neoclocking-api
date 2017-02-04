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
        $projectsQuery = Project::active();

        if (isset($args['number'])) {
            $projectsQuery = $projectsQuery->where('number', $args['number']);
        }

        return $projectsQuery->paginate($args['limit']);
    }
}
