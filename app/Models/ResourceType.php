<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    const CODE_OTHER = 'autre';
    const IDS_SHOULD_NOT_USE = [1];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'resource_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * Get the children.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(ResourceType::class, 'parent_id', 'id');
    }
}
