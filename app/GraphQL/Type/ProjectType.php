<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class ProjectType extends BaseType
{
    protected $attributes = [
        'name' => 'Project',
        'description' => 'Projects'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the project'
            ],
            'active' => [
                'type' => Type::boolean(),
            ],
            'max_time' => [
                'type' => Type::int(),
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The project number'
            ],
            'number' => [
                'type' => Type::string(),
                'description' => 'The project number'
            ],
            'remaining_time' => [
                'type' => Type::int(),
            ],
            'require_comments' => [
                'type' => Type::boolean(),
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'The project number'
            ],
            'should_not_exceed' => [
                'type' => Type::boolean(),
            ],
        ];
    }
}
