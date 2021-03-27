<?php

/**
 * Media Model
 *
 * @category   Media
 * @package    CoRA-Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
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
    protected $table = 'medias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'url', 'archived', 'created_by', 'updated_by'];

    /**
     * The types array for media.
     *
     * @var array
     */
    static public $type = ['Image' => 'Image', 'Audio' => 'Audio', 'Video' => 'Video'];

    /**
     * Get all of the tags for the media.
     */
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
