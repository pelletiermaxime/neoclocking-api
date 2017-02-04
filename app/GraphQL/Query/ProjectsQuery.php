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
            
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return Project::all();
    }
}
