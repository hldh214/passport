<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\LineUser
 *
 * @property int $id
 * @property string $openid
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUser whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LineUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LineUser extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
}
