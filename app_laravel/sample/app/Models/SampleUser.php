<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ユーザ情報を表現することを責務に持つ
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SampleUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SampleUser extends Model
{
    use HasFactory;
}
