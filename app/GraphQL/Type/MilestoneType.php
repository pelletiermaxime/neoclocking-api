<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class MilestoneType extends BaseType
{
    protected $attributes = [
        'name' => 'Milestone',
        'description' => 'Milestones'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the milestone'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The milestone name'
            ],
        ];
    }
}
