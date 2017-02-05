<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProjectRole extends Model
{
    protected $fillable = [
        'user_role_id',
        'user_id',
        'project_id',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_project_roles';

    /**
     * Get the related user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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

    /**
     * Get the related role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }
}
