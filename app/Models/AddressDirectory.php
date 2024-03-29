<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressDirectory extends Model
{
    use HasFactory;
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'AddressDirectory';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'AddressDirectoryID';

    /**
 * The attributes that aren't mass assignable.
 *
 * @var array
 */
protected $guarded = [];
}
//Mauli@Pass4DB

/* 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
*/