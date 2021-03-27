<?php
/**
 * Taphonomy Seeder
 *
 * @category   Taphonomy
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\Taphonomy;

class TaphonomysTableSeeder extends Seeder
{
    public function run()
    {
        $dt = date_create();
        $sys = 'System';

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Adipocere', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Adipocere', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Algae/Fungi/Lichens', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Algae/Fungi/Lichens', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Barnacles', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Barnacles', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Crystals', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Crystals', 'subtype'=>'', 'icon'=>'mdi-diamond-stone', 'color'=>'black', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Desiccated Tissue', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Desiccated Tissue', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Hair/Fur', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Hair/Fur', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Insect Debris', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Insect Debris', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Iron', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Iron', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Copper', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Copper', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Aluminium', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Aluminium', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Silver', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Silver', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Gold', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Gold', 'subtype'=>'', 'icon'=>'mdi-gold', 'color'=>'yellow darken-2', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Metal', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Metal', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Oil Residue', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Oil Residue', 'subtype'=>'', 'icon'=>'mdi-oil', 'color'=>'black', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Other Material', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Other Material', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Roots/Rootlets', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Roots/Rootlets', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Soil', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Soil', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Textile/Impression', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Adherent Materials', 'type'=>'Textile/Impression', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'General Color', 'type'=>'Black', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'General Color', 'type'=>'Black', 'subtype'=>'', 'icon'=>'mdi-palette', 'color'=>'black', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'General Color', 'type'=>'Grey ', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'General Color', 'type'=>'Grey ', 'subtype'=>'', 'icon'=>'mdi-palette', 'color'=>'grey', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'General Color', 'type'=>'Natural', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'General Color', 'type'=>'Natural', 'subtype'=>'', 'icon'=>'mdi-palette', 'color'=>'blue-grey', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'General Color', 'type'=>'Brown to Dark Brown', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'General Color', 'type'=>'Brown to Dark Brown', 'subtype'=>'', 'icon'=>'mdi-palette', 'color'=>'brown', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'General Color', 'type'=>'Tan to Brown', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'General Color', 'type'=>'Tan to Brown', 'subtype'=>'', 'icon'=>'mdi-palette', 'color'=>'deep-orange lighten-3', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'General Color', 'type'=>'Yellow to Tan', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'General Color', 'type'=>'Yellow to Tan', 'subtype'=>'', 'icon'=>'mdi-palette', 'color'=>'yellow lighten-3', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Biological', 'type'=>'Plant', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Biological', 'type'=>'Plant', 'subtype'=>'', 'icon'=>'mdi-sprout', 'color'=>'green', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Biological', 'type'=>'Rodent', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Biological', 'type'=>'Rodent', 'subtype'=>'', 'icon'=>'mdi-rodent', 'color'=>'green', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Biological', 'type'=>'Carnivore', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Biological', 'type'=>'Carnivore', 'subtype'=>'', 'icon'=>'mdi-paw', 'color'=>'green', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Biological', 'type'=>'Bird', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Biological', 'type'=>'Bird', 'subtype'=>'', 'icon'=>'fa-dove', 'color'=>'green', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Biological', 'type'=>'Insect', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Biological', 'type'=>'Insect', 'subtype'=>'', 'icon'=>'mdi-spider', 'color'=>'green', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Biological', 'type'=>'', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Biological', 'type'=>'', 'subtype'=>'', 'icon'=>'mdi-leaf', 'color'=>'green', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Burned', 'type'=>'Smoked', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Burned', 'type'=>'Smoked', 'subtype'=>'', 'icon'=>'mdi-fire', 'color'=>'brown', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Burned', 'type'=>'Charred', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Burned', 'type'=>'Charred', 'subtype'=>'', 'icon'=>'mdi-fire', 'color'=>'brown', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Burned', 'type'=>'Calcined', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Burned', 'type'=>'Calcined', 'subtype'=>'', 'icon'=>'mdi-fire', 'color'=>'brown', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Burned', 'type'=>'Fracture', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Burned', 'type'=>'Fracture', 'subtype'=>'', 'icon'=>'mdi-fire', 'color'=>'brown', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Physical', 'type'=>'Sun bleaching', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Physical', 'type'=>'Sun bleaching', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Physical', 'type'=>'Scratches/Abrasions', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Physical', 'type'=>'Scratches/Abrasions', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Physical', 'type'=>'Plastic Deformation', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Physical', 'type'=>'Plastic Deformation', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Physical', 'type'=>'Cortical Exfoliation/Flaking', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Physical', 'type'=>'Cortical Exfoliation/Flaking', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Physical', 'type'=>'Weathering', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Physical', 'type'=>'Weathering', 'subtype'=>'', 'icon'=>'', 'color'=>'', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Black', 'subtype'=>'Mercury']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Black', 'subtype'=>'Mercury', 'icon'=>'fa-splotch', 'color'=>'black', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Black', 'subtype'=>'Decomposed Plant Material']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Black', 'subtype'=>'Decomposed Plant Material', 'icon'=>'fa-splotch', 'color'=>'black', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Black', 'subtype'=>'Decomposition Fluid']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Black', 'subtype'=>'Decomposition Fluid', 'icon'=>'fa-splotch', 'color'=>'black', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Black', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Black', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'black', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Blue', 'subtype'=>'Vivianite']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Blue', 'subtype'=>'Vivianite', 'icon'=>'fa-splotch', 'color'=>'blue', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Blue', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Blue', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'blue', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Brown', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Brown', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'brown', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Green', 'subtype'=>'Algae/Moss']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Green', 'subtype'=>'Algae/Moss', 'icon'=>'fa-splotch', 'color'=>'green', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Green', 'subtype'=>'Copper/Copper Alloys']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Green', 'subtype'=>'Copper/Copper Alloys', 'icon'=>'fa-splotch', 'color'=>'green', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Green', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Green', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'green', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Grey/Silver', 'subtype'=>'Mercury']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Grey/Silver', 'subtype'=>'Mercury', 'icon'=>'fa-splotch', 'color'=>'grey lighten-1', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Grey/Silver', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Grey/Silver', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'grey lighten-1', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Pink', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Pink', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'pink', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Purple', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Purple', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'purple', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Rust', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Rust', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'deep-orange darken-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Red', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Red', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'red', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Orange', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Orange', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'orange', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'Yellow', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'Yellow', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'yellow', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Staining', 'type'=>'White', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Staining', 'type'=>'White', 'subtype'=>'', 'icon'=>'fa-splotch', 'color'=>'white', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Cut Marks', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Cut Marks', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Intentional Fracture', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Intentional Fracture', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Drill Hole', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Drill Hole', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Excavation Damage', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Excavation Damage', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Bleaching/Cleaning', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Bleaching/Cleaning', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Hardware Attached', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Hardware Attached', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Preservatives', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Preservatives', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Plaster/Reconstruction Materials', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Plaster/Reconstruction Materials', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Bone section removed', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Bone section removed', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Other', 'subtype'=>'']);
        $data = array('branch'=>'Bio', 'category'=>'Human Modification', 'type'=>'Other', 'subtype'=>'', 'icon'=>'mdi-human-male', 'color'=>'brown lighten-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Biological', 'type'=>'Aquatic Scavengers', 'subtype'=>'Large']);
        $data = array('branch'=>'Bio', 'category'=>'Biological', 'type'=>'Aquatic Scavengers', 'subtype'=>'Large', 'icon'=>'mdi-fish', 'color'=>'blue darken-4', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();

        $taph = Taphonomy::firstOrNew(['branch'=>'Bio', 'category'=>'Biological', 'type'=>'Aquatic Scavengers', 'subtype'=>'Small']);
        $data = array('branch'=>'Bio', 'category'=>'Biological', 'type'=>'Aquatic Scavengers', 'subtype'=>'Small', 'icon'=>'mdi-fishbowl', 'color'=>'light-blue darken-1', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$taph->exists) ? $taph->fill($data)->save() : $taph->fill(array_except($data, ['created_at']))->save();
    }
}