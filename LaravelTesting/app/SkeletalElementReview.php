<?php

/**
 * SkeletalElementReview Model
 *
 * @category   SkeletalElementReview
 * @package    CoRA-Models
 * @author     Adam McQuistan<amcquistan@unomaha.edu>, Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;


class SkeletalElementReview extends Model
{
    use SoftDeletes;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['se_id', 'type', 'original', 'review', 'created_by', 'updated_by', 'reviewer_id', 'accepted', 'completed'];

    public function specimen()
    {
        return $this->belongsTo('App\SkeletalElement', 'se_id', 'id');
    }
    
}
