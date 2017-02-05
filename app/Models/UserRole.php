<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    const CODE_MEMBER = 'member';
    const CODE_ASSISTANT = 'assistant';
    const CODE_MANAGER = 'manager';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'priority',
        'code'
    ];
}
