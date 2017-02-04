<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'number',
        'client_id',
        'active',
        'max_time',
        'allocated_time',
        'require_comments',
        'clocking_id',
        'type',
    ];

    protected $hidden = [
        'clocking_id'
    ];

    protected $appends = [
        'allowed_time',
        'logged_time',
        'remaining_time',
    ];

    protected $dates = ['production_end_date'];

    /**
     * Get the related tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the related client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the related milestones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    /**
     * Get the related users' roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userProjectRoles()
    {
        return $this->hasMany(UserProjectRole::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_project_roles')->withTimestamps()->withPivot(['user_role_id']);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->getAttributeFromArray('active');
    }


    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }

    public function scopeCanBeViewedBy($query, User $user)
    {
        if (!$user->canClockAnyProject() && !$user->canManageAnyProject()) {
            $query
                ->join('user_project_roles', 'projects.id', '=', 'user_project_roles.project_id')
                ->where('user_project_roles.user_id', '=', $user->id);
        }
        /*return $query->join('')
            ->where('user_project_roles.user_id', '=', $user->id);*/
        return $this->scopeActive($query);
    }

    /*
    |--------------------------------------------------------------------------
    | Elasticsearch configuration
    |--------------------------------------------------------------------------
    /**
     * Returns an array with properties which must be indexed
     *
     * @return array
     */
    public function getSearchableBody()
    {
        $searchableProperties = [
            'project_name'    => $this->name,
            'project_name.folded'    => $this->name,
            'project_number'  => $this->number,
            'project_number_name_client' => $this->name.' '.$this->number.' '.$this->client->name,
            'project_client_name' => $this->client->name,
            'project_client_name.folded' => $this->client->name,
        ];

        return $searchableProperties;
    }

    /**
     * Return the type of the searchable subject
     *
     * @return string
     */
    public function getSearchableType()
    {
        return 'project';
    }

    /**
     * Return the id of the searchable subject
     *
     * @return string
     */
    public function getSearchableId()
    {
        return $this->id;
    }

    public function getShouldNotExceedAttribute()
    {
        return $this->type == 'Banque d\'heures';
    }

    protected function getAllowedTimeAttribute()
    {
        $totalAllottedTime = 0;

        foreach ($this->tasks as $task) {
            if ($task->revised_estimation) {
                $totalAllottedTime += $task->revised_estimation;
            } else {
                $totalAllottedTime += $task->estimation;
            }
        }

        return $totalAllottedTime;
    }

    protected function getLoggedTimeAttribute()
    {
        return $this->tasks()->sum('logged_time');
    }

    protected function getRemainingTimeAttribute()
    {
        return $this->max_time - $this->tasks()->sum('logged_time');
    }
}
