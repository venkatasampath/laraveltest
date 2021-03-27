<?php
/**
 * Created by PhpStorm.
 * User: 1234
 * Date: 4/11/2018
 * Time: 7:28 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DentalCode extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'description', 'type', 'category', 'icon', 'color', 'created_by', 'updated_by', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skeletalbone()
    {
        return $this->belongsTo('App\SkeletalBone', 'sb_id');
    }
    public function skeletalelement()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_dental_code','dc_id','se_id');
    }
}