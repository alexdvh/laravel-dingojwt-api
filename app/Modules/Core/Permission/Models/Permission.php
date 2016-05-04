<?php 
namespace App\Modules\Core\Permission\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Permission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';
 
    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */
 
    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function roles()
    {
        return $this->belongsToMany('App\Modules\Core\Role\Models\Role');
    }
}
