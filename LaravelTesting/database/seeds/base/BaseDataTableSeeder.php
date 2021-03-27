<?php
use Illuminate\Database\Seeder;
use App\User;
use App\Org;
use App\Profile;
use App\Eula;
use TCG\Voyager\Models\Role;

class BaseOrgsTableSeeder extends Seeder {

    public function run()
    {
        $org = Org::firstOrNew(['name' => 'University of Nebraska at Omaha', 'acronym' => 'UNO']);
        $data = array('name' => 'University of Nebraska at Omaha', 'address' => 'University of Nebraska Omaha, 6001 Dodge Street',
            'acronym' => 'UNO', 'city' => 'Omaha', 'state' => 'NE', 'zip' => '68182',
            'description' => 'University of Nebraska at Omaha partner of DPAA', 'acronym' => 'UNO',
            'geo_lat' => 41.258481, 'geo_long' => -96.010379, 'website' => 'http://www.unomaha.edu/', 'phone' => '402.554.2800',
            'toll_free' => '', 'fax' => '', 'contact_name' => '', 'contact_email' => '',
            'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create());
        (!$org->exists) ? $org->fill($data)->save() : $org->fill(array_except($data, ['created_at']))->save();
    }
}

class BaseUsersTableSeeder extends Seeder {

    public function run()
    {
        // Admin is now seeder via Voyager
    }
}

class BaseRolesTableSeeder extends Seeder {

    public function run()
    {
        $role = Role::firstOrNew(['name' => 'orgadmin']);
        $data = array('name' => 'orgadmin', 'display_name' => 'Org Administrator', 'description' => 'User is allowed to manage and edit other users within their organization');
        (!$role->exists) ? $role->fill($data)->save() : $role->fill(array_except($data, ['created_at']))->save();
    }
}

class BaseProfilesTableSeeder extends Seeder {

    public function run()
    {
        // System profiles
        $profile = Profile::firstOrNew(['name' => 'eula_processing']);
        $data = array('name' => 'eula_processing', 'description' => 'Eula Processing', 'default_value' => 'false', 'kind' => 'bool',
            'display_type' => 'checkbox', 'display_values' => '', 'type' => 'system', 'group' => 'ui', 'display_order' => 1040,
            'help' => 'Displays the Eula Acceptance Screen on startup when the user logs into the application for the first time',
            'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        // Org profiles
        $profile = Profile::firstOrNew(['name' => 'welcome_screen_url']);
        $data = array('name' => 'welcome_screen_url', 'description' => 'Welcome Screen URL', 'default_value' => '\welcome', 'kind' => 'url',
                'display_type' => 'text', 'display_values' => '', 'type' => 'org', 'group' => 'ui', 'display_order' => 1050,
                'help' => 'Configure the URL for the welcome screen that is displayed to the user on startup when the user logs into the application.',
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        // User profiles
        $profile = Profile::firstOrNew(['name' => 'lines_per_page']);
        $data = array('name' => 'lines_per_page', 'description' => 'Lines per Page', 'default_value' => '10', 'kind' => 'int',
                'display_type' => 'select', 'display_values' => '{"10":10, "25":25, "50":50, "100":100}', 'type' => 'user', 'group' => 'ui', 'display_order' => 1010,
                'help' => 'Controls the numbers of rows of data displayed for views with tables',
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name' => 'welcome_screen_on_startup']);
        $data = array('name' => 'welcome_screen_on_startup', 'description' => 'Welcome Screen on Startup', 'default_value' => 'true', 'kind' => 'bool',
                'display_type' => 'checkbox', 'display_values' => '', 'type' => 'user', 'group' => 'ui', 'display_order' => 1030,
                'help' => 'Displays the Welcome Screen on startup when the user logs into the application.',
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();
    }
}

class BaseEulasTableSeeder extends Seeder {

    public function run()
    {
        $org = Org::where('name', '=', 'University of Nebraska at Omaha')->first();

        $eula = Eula::firstOrNew(['org_id' => $org->id, 'version' => '1.0']);
        $data = array('org_id' => $org->id, 'version' => '1.0', 'country' => 'US', 'language' => 'en', 'status' => 'Active',
            'agreement' => 'End-User License Agreement for CoRA
                        This End-User License Agreement (EULA) is a legal agreement between you (either an individual or a single entity) and the mentioned author (CoRA) of this Software for the software product identified above, which includes computer software and may include associated media, printed materials, and “online” or electronic documentation (“SOFTWARE PRODUCT”).

                        By installing, copying, or otherwise using the SOFTWARE PRODUCT, you agree to be bounded by the terms of this EULA.
                        If you do not agree to the terms of this EULA, do not install or use the SOFTWARE PRODUCT.

                        SOFTWARE PRODUCT LICENSE
                        a) CoRA Free Version is being distributed as Freeware for personal, commercial use, non-profit organization, educational purpose. It may be included with CD-ROM/DVD-ROM distributions. You are NOT allowed to make a charge for distributing this Software (either for profit or merely to recover your media and distribution costs) whether as a stand-alone product, or as part of a compilation or anthology, nor to use it for supporting your business or customers. It may be distributed freely on any website or through any other distribution mechanism, as long as no part of it is changed in any way.
                        b) CoRA Professional Version, another all-in-one diagram software, is available with more advanced features.

                        1. GRANT OF LICENSE. This EULA grants you the following rights: Installation and Use. You may install and use an unlimited number of copies of the SOFTWARE PRODUCT.
                        Reproduction and Distribution. You may reproduce and distribute an unlimited number of copies of the SOFTWARE PRODUCT; provided that each copy shall be a true and complete copy, including all copyright and trademark notices, and shall be accompanied by a copy of this EULA.
                        Copies of the SOFTWARE PRODUCT may be distributed as a standalone product or included with your own product as long as The SOFTWARE PRODUCT is not sold or included in a product or package that intends to receive benefits through the inclusion of the SOFTWARE PRODUCT.

                        The SOFTWARE PRODUCT may be included in any free or non-profit packages or products.

                        2. DESCRIPTION OF OTHER RIGHTS AND LIMITATIONS.
                        Limitations on Reverse Engineering, Decompilation, Disassembly and change (add,delete or modify) the resources in the compiled the assembly. You may not reverse engineer, decompile, or disassemble the SOFTWARE PRODUCT, except and only to the extent that such activity is expressly permitted by applicable law notwithstanding this limitation.

                        Update and Maintenance
                        CoRA upgrades are FREE of charge.

                        Separation of Components.
                        The SOFTWARE PRODUCT is licensed as a single product. Its component parts may not be separated for use on more than one computer.

                        Software Transfer.
                        You may permanently transfer all of your rights under this EULA, provided the recipient agrees to the terms of this EULA.

                        Termination.
                        Without prejudice to any other rights, the Author of this Software may terminate this EULA if you fail to comply with the terms and conditions of this EULA. In such event, you must destroy all copies of the SOFTWARE PRODUCT and all of its component parts.

                        3. COPYRIGHT.
                        All title and copyrights in and to the SOFTWARE PRODUCT (including but not limited to any images, photographs, clipart, libraries, and examples incorporated into the SOFTWARE PRODUCT), the accompanying printed materials, and any copies of the SOFTWARE PRODUCT are owned by the Author of this Software. The SOFTWARE PRODUCT is protected by copyright laws and international treaty provisions. Therefore, you must treat the SOFTWARE PRODUCT like any other copyrighted material. The licensed users or licensed company can use all functions, example, templates, clipart, libraries and symbols in the SOFTWARE PRODUCT to create new diagrams and distribute the diagrams.
                    
                        LIMITED WARRANTY
                    
                        NO WARRANTIES.
                        The Author of this Software expressly disclaims any warranty for the SOFTWARE PRODUCT. The SOFTWARE PRODUCT and any related documentation is provided “as is” without warranty of any kind, either express or implied, including, without limitation, the implied warranties or merchantability, fitness for a particular purpose, or noninfringement. The entire risk arising out of use or performance of the SOFTWARE PRODUCT remains with you.
                        
                        NO LIABILITY FOR DAMAGES.
                        In no event shall the author of this Software be liable for any special, consequential, incidental or indirect damages whatsoever (including, without limitation, damages for loss of business profits, business interruption, loss of business information, or any other pecuniary loss) arising out of the use of or inability to use this product, even if the Author of this Software is aware of the possibility of such damages and known defects.',

            'file_type' => 'Text', 'effective_at' => date_create(),
            'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create());
        (!$eula->exists) ? $eula->fill($data)->save() : $eula->fill(array_except($data, ['created_at']))->save();
    }
}

