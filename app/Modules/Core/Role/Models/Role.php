<?php
 
namespace App\Modules\Core\Role\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';
 
    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */
 
    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function users()
    {
        return $this->belongsToMany('App\Modules\Core\User\Models\User');
    }
 
    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Modules\Core\Permission\Models\Permission');
    }
}
