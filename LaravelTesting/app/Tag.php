<?php

/**
 * Tag Model
 *
 * @category   Tag
 * @package    Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'org_id', 'project_id', 'type', 'category', 'description', 'color', 'icon'];

    /**
     * The categories array for media.
     *
     * @var array
     */
    static public $allowed_types = ['Specimen'=>'Specimen', 'Dna'=>'Dna', 'Isotope'=>'Isotope', 'Media'=>'Media'];

    /**
     * Get all of the specimens that are assigned this tag.
     */
    public function skeletalelements()
    {
        return $this->morphedByMany('App\SkeletalElement', 'taggable');
    }

    /**
     * Get all of the se's that are assigned this tag.
     */
    public function se()
    {
        return $this->skeletalelements();
    }

    /**
     * Get all of the specimens that are assigned this tag.
     */
    public function specimens()
    {
        return $this->skeletalelements();
    }

    /**
     * Get all of the dnas that are assigned this tag.
     */
    public function dnas()
    {
        return $this->morphedByMany('App\Dna', 'taggable');
    }

    /**
     * Get all of the isotopes that are assigned this tag.
     */
    public function isotopes()
    {
        return $this->morphedByMany('App\Isotope', 'taggable');
    }

    /**
     * Get all of the dnas that are assigned this tag.
     */
    public function medias()
    {
        return $this->morphedByMany('App\Media', 'taggable');
    }

//    public function computedType()
//    {
//        // This needs to be implemented for every object that requires a tag
//        if (strpos($this->taggable_type, 'SkeletalElement') !== false) {
//            return "SkeletalElement";
//        } else if (strpos($this->taggable_type, 'DNA') !== false) {
//            return "DNA";
//        } else if (strpos($this->taggable_type, 'Isotope') !== false) {
//            return "Isotope";
//        } else if (strpos($this->taggable_type, 'Media') !== false) {
//            return "Media";
//        } else {
//            return "Unknown";
//        }
//    }

    /**
     * Scope a query to only include tags for specified category.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', '=', $category);
    }

    /**
     * Scope a query to only include tags of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', '=', $type);
    }
}
