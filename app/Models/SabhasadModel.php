<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
class SabhasadModel extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbSabhasad';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'sabhasadID';

    /**
 * The attributes that aren't mass assignable.
 *
 * @var array
 */
protected $guarded = [];
}
