<?php

/**
 * SkeletalBone Model
 *
 * @category   SkeletalBone
 * @package    CoRA-Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

/**
 * Class SkeletalBone
 * @package App
 */
class SkeletalBone extends Model
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
    protected $fillable = ['name', 'search_name', 'category', 'type', 'group', 'description',
        'paired', 'articulated', 'refit', 'morphology', 'zones', 'measurements', 'methods', 'dental', 'countable', 'mni',
        'image_zones', 'image_measurements', 'created_by', 'updated_by'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skeletalelements()
    {
        return $this->hasMany('App\SkeletalElement', 'sb_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function measurements()
    {
        return $this->hasMany('App\Measurement', 'sb_id');
    }

    /**
     * @return bool
     */
    public function hasMeasurements()
    {
        $list = $this->measurements()->get();
        return (count($list)) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function zones()
    {
        return $this->hasMany('App\Zone', 'sb_id');
    }

    /**
     * @return bool
     */
    public function hasZones()
    {
        $list = $this->zones()->get();
        return (count($list)) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function methods()
    {
        return $this->hasMany('App\Method', 'sb_id');
    }

    /**
     * @return bool
     */
    public function hasMethods()
    {
        $list = $this->methods()->get();
        return (count($list)) ? true : false;
    }

    /**
     * @param $type
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function methodsByType($type)
    {
        return $this->hasMany('App\Method', 'sb_id')
            ->where('type', $type);
    }

    /**
     * @param $type
     * @return bool
     */
    public function hasMethodsByType($type)
    {
        $list = $this->methodsByType($type)->get();
        return (count($list)) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function anomalys()
    {
        return $this->hasMany('App\Anomaly', 'sb_id');
    }

    /**
     * @return bool
     */
    public function hasAnomalys()
    {
        $list = $this->anomalys()->get();
        return (count($list)) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function articulations()
    {
        return $this->belongsToMany('App\SkeletalBone', 'articulations', 'sb_id', 'articulation_id')
            ->withTimestamps();
    }

    /**
     * @return bool
     */
    public function hasArticulations()
    {
        $list = $this->articulations()->get();
        return (count($list)) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function morphologys()
    {
        return $this->belongsToMany('App\SkeletalBone', 'morphologys', 'sb_id', 'morphology_id')
            ->withTimestamps();
    }

    /**
     * @return bool
     */
    public function hasMorphologys()
    {
        $list = $this->morphologys()->get();
        return (count($list)) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bonegroups()
    {
        return $this->hasMany('App\BoneGroup', 'sb_id');
    }

    /**
     * @return bool
     */
    public function belongToBoneGroup()
    {
        $list = $this->bonegroups()->get();
        return (count($list)) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dentals()
    {
        return $this->hasMany('App\DentalCode', 'sb_id');
    }

    /**
     * Returns an image for the Bone based upon $type. The $type can currently be zones or measurements
     * The images must be in correct format (png) and stored in the storage/images/$type directory
     * The image file name must be in the image_zones database field for respective bone record
     *
     * @param $type
     * @return string
     */
    public function getImage($type)
    {
        $defaultPathImages = config('app.images.sb.'.$type);

        if($type=='zones') {
            $file = $defaultPathImages.'/'.$this->image_zones;
            $img = file_exists($file) ? $file : $defaultPathImages.'/default_500.png';
            if (!isset($this->image_zones)) {
                $img = $defaultPathImages.'/default_500.png';
            }
            return URL::to('/').'/'.$img;
        } elseif ($type=='measurements') {
            $file = $defaultPathImages.'/'.$this->image_measurements;
            $img = file_exists($file) ? $file : $defaultPathImages.'/default_500.png';
            if (!isset($this->image_measurements)) {
                $img = $defaultPathImages.'/default_500.png';
            }
            return URL::to('/').'/'.$img;
        } else {
            return URL::to('/').'/unknown-sb-image-type.png'; // should never get here.
        }
    }
}
