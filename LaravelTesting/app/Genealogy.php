<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Genealogy extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $table='genealogys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid','org_id','project_id','mp_id','case_manager_id','priority','notes','enclosed_documents',
        'company','funded_by','request_date','receive_date'];

    public function missingperson()
    {
        return $this->HasMany('App\MissingPerson', 'mp_id');
    }

}
