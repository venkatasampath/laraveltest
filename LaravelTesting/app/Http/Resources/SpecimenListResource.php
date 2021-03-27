<?php

/**
 * Cora Resource for Specimen Lists
 *
 * @category
 * @package    CoRA-Resources
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2020, Sachin Pawaskar, All rights reserved.
 * @license    Proprietary software, All rights reserved.
 * @version    GIT: $Id$
 * @since      File available since Release 3.0.0
 */

namespace App\Http\Resources;

class SpecimenListResource extends CoraResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'key' => $this->key,
            'key_bone_side' => $this->key_bone_side,
//            'key_bone_side' => $this->when(isset($this->key_bone_side), $this->key_bone_side),
        ];

        return $result;
    }
}
