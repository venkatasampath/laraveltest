<?php

/**
 * Profiles Trait
 *
 * @category   Profiles
 * @package    CoRA-Traits
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Traits;

use App\Events\ProfileChanged;
use App\Profile;
use Auth;
use Cache;
use Log;
use App\Project;

/**
 * Trait ProfilesTrait
 * @package App\Http\Traits
 */
trait ProfilesTrait {

    public $fireProfileChanged = true;

    // get profile value
    public function getProfileValue($name)
    {
        $profile = $this->profiles()->where(['profileable_id' => $this->id, 'profileable_type' => $this->getMorphClass(), 'name' => $name])->first();
        if ($profile) {
            return $this->stringToKind($profile, $profile->pivot->value);
        } else {
            return $this->getProfileDefaultValue($name);
        }
    }

    // get profile default value
    public function getProfileDefaultValue($name)
    {
        $profile = Profile::where(['name' => $name])->first();
        if ($profile) {
            return $this->stringToKind($profile, $profile->default_value);
        } else { // Should never get here unless developer is asking for a profile not defined in the System
            return null;
        }
    }

    // get profile display values
    public function getProfileDisplayValues($name)
    {
        $profile = Profile::where(['name' => $name])->first();
        if ($profile) {
            if ($profile->kind === 'object' || $profile->kind === 'model') {
                /**
                 * example {"model":"App\\User", "field":"name", "whereCol":"name", "whereOp":"!=", "whereValue":"System"}
                 * example {"model":"App\\User", "field":"name"}
                 * example {"model":"Project", "field":"name", "orgFilter":true, "publicFilter":true}
                 * for debugging
                 * $json = '{"model":"User", "field":"name"}';
                 * var_dump(json_decode($json));
                 * var_dump(json_decode($json, true));
                 */

                $opts = json_decode($profile->display_values, true);
                $namedModel = array_has($opts, 'model') ? $opts['model'] : null;
                $app_nameModel = 'App\\' . $namedModel;
                $field = array_has($opts, 'field') ? $opts['field'] : null;
                $whereCol = array_has($opts, 'whereCol') ? $opts['whereCol'] : null;
                $orgFilter = array_has($opts, 'orgFilter') ? $opts['orgFilter'] : null;
                $publicFilter = array_has($opts, 'publicFilter') ? $opts['publicFilter'] : null;
//                dd([$name, $profile, $opts, $namedModel, $app_nameModel, $field, $whereCol]);
                // ToDo: orgFilter: boolean, public: true
                if (!empty($whereCol)) {
                    $whereOp = array_has($opts, 'whereOp') ? $opts['whereOp'] : null;
                    $whereValue = array_has($opts, 'whereValue') ? $opts['whereValue'] : null;
                    $whereValue = $this->org->id;
//                    dd([$name, $profile, $opts, $namedModel, $app_nameModel, $field, $whereCol, $whereOp, $whereValue]);
                    return $app_nameModel::where($whereCol, $whereOp, $whereValue)->pluck($field, 'id');
                } else {
                    if (!empty($orgFilter) && $orgFilter === true) {
                        $query = $app_nameModel::where('org_id', '=', $this->org->id);
                        if (!empty($publicFilter) && $publicFilter === true) {
                            $query->orWhere('public', '=', true);
                        }
                        return $query->pluck($field, 'id');
                    } else {
                        if (!empty($publicFilter) && $publicFilter === true) {
                            $query = $app_nameModel::where('public', '=', true);
                            return $query->pluck($field, 'id');
                        } else {
                            return $app_nameModel::pluck($field, 'id');
                        }
                    }
                }
            } else {
                return $profile->display_values;
            }
        } else { // Should never get here unless developer is asking for a profile not defined in the System
            return null;
        }
    }

    // get profile default values
    public function getProfileDisplayDefaultValue($name)
    {
        $profile = Profile::where(['name' => $name])->first();
        if ($profile) {
            if ($profile->kind === 'object' || $profile->kind === 'model') {
                $opts = json_decode($profile->display_values, true);
                $namedModel = array_has($opts, 'model') ? $opts['model'] : null;
                $app_nameModel = 'App\\' . $namedModel;
                $field = array_has($opts, 'field') ? $opts['field'] : null;
                $whereCol = array_has($opts, 'whereCol') ? $opts['whereCol'] : null;
                $orgFilter = array_has($opts, 'orgFilter') ? $opts['orgFilter'] : null;
                return $app_nameModel::find($profile->default_value)->name;
            } else {
                return $profile->default_value;
            }
        } else { // Should never get here unless developer is asking for a profile not defined in the System
            return null;
        }
    }

    // get profile min value
    public function getProfileValueMin($name)
    {
        $profile = Profile::where(['name' => $name])->first();
        if ($profile) {
            $opts = json_decode($profile->display_values, true);
            return array_has($opts, 'min') ? $opts['min'] : null;
        } else {
            return null;
        }
    }

    // get profile max value
    public function getProfileValueMax($name)
    {
        $profile = Profile::where(['name' => $name])->first();
        if ($profile) {
            $opts = json_decode($profile->display_values, true);
            return array_has($opts, 'max') ? $opts['max'] : null;
        } else {
            return null;
        }
    }

    // get profile max value
    public function getProfileValueStep($name)
    {
        $profile = Profile::where(['name' => $name])->first();
        if ($profile) {
            $opts = json_decode($profile->display_values, true);
            return array_has($opts, 'step') ? $opts['step'] : null;
        } else {
            return null;
        }
    }

    // get profile help text
    public function getProfileHelp($name)
    {
        $profile = Profile::where(['name' => $name])->first();
        if ($profile) {
            return $profile->help;
        } else {
            return null;
        }
    }

    // get profile Json values
    public function getProfileJsonValues($name)
    {
        $profile = $this->profiles()->where(['profileable_id' => $this->id, 'profileable_type' => $this->getMorphClass(), 'name' => $name])->first();
        if ($profile) {
            return $profile->pivot->json_values;
        } else {
            return null;
        }
    }

    // get profile Json values as an array
    public function getProfileJsonValuesArray($name)
    {
        $json_values = $this->getProfileJsonValues($name);
        if (!empty($json_values)) {
            $values = unserialize($json_values);
            return $values;
        } else {
            return null;
        }
    }

    // get profile Json values as an array
    public function getProfileJsonValuesCount($name)
    {
        $json_values = $this->getProfileJsonValues($name);
        if (!empty($json_values)) {
            $values = unserialize($json_values);
            return count($values);
        } else {
            return 0;
        }
    }

    // get profile
    public function getProfile($name)
    {
        return $this->profiles()->where(['profileable_id' => $this->id, 'profileable_type' => $this->getMorphClass(), 'name' => $name])->first();
//        $profiles = $this->getCache();
//        $value = array_get($profiles, $name);
//        return ($value !== '') ? $value : NULL;
    }

    // create-update profile
    public function setProfile($name, $value)
    {
        $this->storeProfile($name, $value);
//        $this->setCache();
    }

    // create-update multiple profiles at once
    public function setProfiles($data = [])
    {
        foreach($data as $name => $value)
        {
            $this->storeProfile($name, $value);
        }
//        $this->setCache();
    }

    private function storeProfile($name, $value)
    {
        $record = $this->profiles()->where(['profileable_id' => $this->id, 'profileable_type' => $this->getMorphClass(), 'name' => $name])->first();
        if($record)
        {
            Log::info(__METHOD__.' ['.$this->name.'] - Update Existing Pivot: '.$record->name.':'.$value);
            $this->profiles()->updateExistingPivot($record->id, ['value' => $value, 'updated_by' => $this->name ]);
        } else {
            $profile = Profile::where(['name' => $name])->first();
            Log::info(__METHOD__.' ['.$this->name.'] - Save New: '.$profile->name.':'.$value);
            $this->profiles()->save($profile, ['value' => $value, 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ]);
            $record = $profile;
        }
        if ($this->fireProfileChanged) {
            event(new ProfileChanged($record, $this));
        }
    }

    // create-update profile
    public function addProfileJsonValue($name, $object)
    {
        $this->storeProfileJsonValue($name, $object);
    }

    private function storeProfileJsonValue($name, $object)
    {
        $record = $this->profiles()->where(['profileable_id' => $this->id, 'profileable_type' => $this->getMorphClass(), 'name' => $name])->first();
        if($record)
        {
            Log::info(__METHOD__.' ['.$this->name.'] - Update Existing Pivot: '.$record->name.':'.$object->id);
            $json_values = $this->buildProfileJson($record, $object);
            $json_values = (count($json_values) > $record->pivot->value) ? array_slice($json_values, 0, $record->pivot->value) : $json_values;
            $this->profiles()->updateExistingPivot($record->id, ['json_values' => serialize($json_values), 'updated_by' => $this->name ]);
        } else {
            $profile = Profile::where(['name' => $name])->first();
            $json_values = $this->buildProfileJson(null, $object);
            Log::info(__METHOD__.' ['.$this->name.'] - Save New: '.$profile->name.':'.$object->id);
            $this->profiles()->save($profile, ['value' => $profile->default_value, 'json_values' => serialize($json_values), 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ]);
        }
    }


    private function buildProfileJson($record, $object)
    {
        $values = [];
        if ($record) {
            if (!empty($record->pivot->json_values)) {
                $values = unserialize($record->pivot->json_values);
                $key = array_search($object->id, array_column($values, 'id'));
                if ($key !== false)
                    unset($values[$key]);
            }
        }

        $values = array_prepend($values, ['id' => $object->id, 'name' => $object->name, 'project_id' => $object->project_id]);
//        Log::info(__METHOD__.' - json_values: ' . serialize($values));
        return $values;
    }

    // ToDo: implement caching for profiles at some point.
    private function getCache()
    {
        if (Cache::has('user_profiles_' . $this->id))
        {
            return Cache::get('user_profiles_' . $this->id);
        }
        return $this->setCache();
    }

    private function setCache()
    {
        if (Cache::has('user_profiles_' . $this->id))
        {
            Cache::forget('user_profiles_' . $this->id);
        }
        $profiles = $this->profiles->lists('value','name');
        Cache::forever('user_profiles_' . $this->id, $profiles);
        return $this->getCache();
    }

    public function stringToKind($profile, $value)
    {
        if ($profile->kind === 'boolean' || $profile->kind === 'bool') {
            return ($value === 'true' || $value === '1') ? true : false;
        } else if ($profile->kind === 'int' || $profile->kind === 'integer') {
            return intval($value);
        } else {
//            Log::info(__METHOD__.'- name='.$profile->name.' kind='.$profile->kind.' value='.$value);
            return $value;
        }
    }

    public function setFireProfileChanged($flag) {
        $this->fireProfileChanged = $flag;
    }
}