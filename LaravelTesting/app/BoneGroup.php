<?php

/**
 * Bone Group Model
 *
 * @category   Bone Group
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

class BoneGroup extends Model
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
    protected $fillable = ['sb_id', 'group_name', 'side', 'display_order', 'for_inventory', 'for_articulation',
        'created_by', 'updated_by'];

    /**
     * Get all of the skeletalbones that are assigned this articulation.
     */
    public function skeletalbone()
    {
        return $this->belongsTo('App\SkeletalBone', 'sb_id');
    }

    public static function isGroupSided($group_name)
    {
        $bonesInBoneGroup = BoneGroup::where('group_name', '=', $group_name)->get();
        foreach ($bonesInBoneGroup as $boneGroupRecord) {
            if ($boneGroupRecord->side) {
                return true;
            }
        }
        return false;
    }

    public static function isBoneInGroupSided($group_name, $bone_id)
    {
        $boneInBoneGroup = BoneGroup::where('group_name', '=', $group_name)->where('sb_id', $bone_id)->first();
        if ( isset($boneInBoneGroup) && $boneInBoneGroup->side ) {
            return true;
        }
        return false;
    }
}
