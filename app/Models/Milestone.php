<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Milestone
 *
 * @property integer $id
 * @property string $name
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Milestone whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Milestone whereName($value)
 */
class Milestone extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'milestones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'project_id'
    ];


    /**
     * Get the related status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    /**
     * Get the related project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
