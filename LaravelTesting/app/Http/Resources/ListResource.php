<?php

/**
 * Cora Resource for Lists
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

use App\Comment;
use App\SkeletalBone;
use App\Anomaly;
use App\Measurement;
use App\SkeletalElement;
use App\Instrument;
use App\Method;
use App\MethodFeature;
use App\Pathology;
use App\Tag;
use App\Trauma;
use App\Taphonomy;
use App\Zone;
use App\Profile;
use App\ProjectStatus;
use App\Lab;
use App\DnaAnalysisType;
use App\Permission;
use App\BoneGroup;
use OwenIt\Auditing\Models\Audit;

class ListResource extends CoraResource
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
            'id' => $this->when(isset($this->id), $this->id),
            'name' => $this->when(isset($this->name), $this->name),
            'key' => $this->when(isset($this->key), $this->key),
            'key_bone_side' => $this->when(isset($this->key_bone_side), $this->key_bone_side),
//            'model_class' => get_class($this->resource),
        ];

        if ($this->resource instanceof SkeletalBone) {
            $result['middle'] = $this->middle;
        } else if ($this->resource instanceof Anomaly) {
            $result['individuating_trait'] = $this->individuating_trait;
        } else if ($this->resource instanceof Measurement) {
            $result['display_name'] = $this->display_name;
            $result['display_order'] = $this->display_order;
            $result['description'] = $this->description;
            $result['min_value'] = $this->min_value;
            $result['max_value'] = $this->max_value;
            $result['step_value'] = $this->step_value;
            $result['min_threshold'] = $this->min_threshold;
            $result['max_threshold'] = $this->max_threshold;
            $result['instrument'] = $this->instrument;
            $result['comment'] = $this->comment;
            $result['display_help'] = $this->display_help;
            $result['help_url'] = $this->help_url;
            $result['measure'] = $this->whenPivotLoaded('se_measurement', function () {
                return $this->pivot->measure;
            });
        } else if ($this->resource instanceof Zone) {
            $result['display_name'] = $this->display_name;
            $result['display_order'] = $this->display_order;
            $result['description'] = $this->description;
            $result['display_help'] = $this->display_help;
            $result['help_url'] = $this->help_url;
            $result['presence'] = $this->whenPivotLoaded('se_zone', function () {
                return $this->pivot->presence;
            });
        } else if ($this->resource instanceof Method) {
            $result['type'] = $this->type;
            $result['reference'] = $this->reference;
            $result['submethod'] = $this->submethod;
            $result['description'] = $this->description;
            $result['uses_feature_score'] = $this->uses_feature_score;
            $result['uses_composite_score'] = $this->uses_composite_score;
            $result['feature_groups'] = $this->feature_groups;
            $result['display_help'] = $this->display_help;
            $result['help_url'] = $this->help_url;
        } else if ($this->resource instanceof MethodFeature) {
            $result['feature'] = $this->feature;
            $result['display_name'] = $this->display_name;
            $result['display_order'] = $this->display_order;
            $result['display_values'] = $this->display_values;
            $result['display_interval'] = $this->display_interval;
            $result['computed'] = $this->computed;
            $result['compute_rule'] = $this->compute_rule;
            $result['groups'] = $this->groups;
            $result['display_help'] = $this->display_help;
            $result['method_id'] = $this->whenPivotLoaded('se_method_feature', function () {
                return $this->pivot->method_id;
            });
            $result['method_feature_id'] = $this->whenPivotLoaded('se_method_feature', function () {
                return $this->pivot->method_feature_id;
            });
            $result['score'] = $this->whenPivotLoaded('se_method_feature', function () {
                return $this->pivot->score;
            });
        } else if ($this->resource instanceof Taphonomy) {
            $result['fullname'] = $this->name;
            $result['name'] = $this->name_without_branch;
            $result['branch'] = $this->branch;
            $result['category'] = $this->category;
            $result['type'] = $this->type;
            $result['subtype'] = $this->subtype;
            $result['icon'] = $this->icon;
            $result['color'] = $this->color;
        } else if ($this->resource instanceof Pathology) {
            $result['abnormality_category'] = $this->abnormality_category;
            $result['characteristics'] = $this->characteristics;
            $result['zone_id'] = $this->whenPivotLoaded('se_pathology', function () {
                return $this->pivot->zone_id;
            });
            $result['additional_information'] = $this->whenPivotLoaded('se_pathology', function () {
                return $this->pivot->additional_information;
            });
        } else if ($this->resource instanceof Trauma) {
            $result['timing'] = $this->timing;
            $result['type'] = $this->type;
            $result['zone_id'] = $this->whenPivotLoaded('se_trauma', function () {
                return $this->pivot->zone_id;
            });
            $result['additional_information'] = $this->whenPivotLoaded('se_trauma', function () {
                return $this->pivot->additional_information;
            });
        } else if ($this->resource instanceof Tag) {
            $result['type'] = $this->type;
            $result['category'] = $this->category;
            $result['description'] = $this->description;
            $result['color'] = $this->color;
            $result['icon'] = $this->icon;
        } else if ($this->resource instanceof Comment) {
            $result['text'] = $this->text;
            $result['commentable_id'] = $this->commentable_id;
            $result['commentable_type'] = $this->commentable_type;
            $result['user_id'] = $this->user_id;
            $result['created_at'] = $this->created_at;
            $result['updated_at'] = $this->updated_at;
        } else if ($this->resource instanceof Profile) {
            $result['description'] = $this->description;
            $result['help'] = $this->help;
            $result['default_value'] = $this->default_value;
            $result['value'] = $this->whenPivotLoaded('profileables', function () {
                return $this->pivot->value;
            });
            $result['json_values'] = $this->whenPivotLoaded('profileables', function () {
                return $this->pivot->json_values;
            });
        } else if ($this->resource instanceof Lab) {
            $result['description'] = $this->description;
            $result['type'] = $this->type;
            $result['name_description'] = $this->name . " - " . $this->description;
        } else if ($this->resource instanceof DnaAnalysisType) {
            $result['description'] = $this->description;
            $result['display_name'] = $this->display_name;
            $result['type'] = $this->type;
        } else if ($this->resource instanceof Permission) {
            $result['table_name'] = $this->table_name;
        } else if ($this->resource instanceof ProjectStatus) {
            $result['display_name'] = $this->display_name;
            $result['display_order'] = $this->display_order;
        } else if ($this->resource instanceof Instrument) {
            $result['code'] = $this->code;
            $result['module'] = $this->module;
            $result['category'] = $this->category;
            $result['reference'] = $this->refefrence;
            $result['active'] = $this->active;
            $result['full_name'] = $this->when(isset($this->full_name), $this->full_name);
        } else if ($this->resource instanceof BoneGroup) {
            $result['group_name'] = $this->group_name;
            $result['sb_id'] = $this->sb_id;
            $result['side'] = $this->side;
            $result['middle'] = $this->middle;
            $result['display_order'] = $this->display_order;
            $result['for_inventory'] = $this->for_inventory;
            $result['for_articulation'] = $this->for_articulation;
        } else if ($this->resource instanceof Audit) {
            $result['user_type'] = $this->user_type;
            $result['user_id'] = $this->user_id;
            $result['event'] = $this->event;
            $result['auditable_id'] = $this->auditable_id;
            $result['old_values'] = $this->old_values;
            $result['new_values'] = $this->new_values;
            $result['url'] = $this->url;
            $result['ip_address'] = $this->ip_address;
            $result['user_agent'] = $this->user_agent;
            $result['tags'] = $this->tags;
            $result['created_at'] = $this->created_at;
            $result['updated_at'] = $this->updated_at;
        } else {
            $result['model_class'] = get_class($this->resource);
        }

        return $result;
    }
}
