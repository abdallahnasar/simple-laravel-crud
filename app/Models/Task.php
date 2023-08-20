<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Task
 * @package App\Models
 * @version August 19, 2023, 11:27 pm +03
 *
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $status
 */
class Task extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'tasks';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'title',
        'description',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|integer|exists:users,id',
        'title' => 'required',
        'status' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
