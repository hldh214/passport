<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\LineUserBinding
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $line_user_id
 * @property int $teacher_id
 * @property int $student_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding whereLineUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUserBinding whereUpdatedAt($value)
 */
class LineUserBinding extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(LineUser::class, 'line_user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
