<?php

use Illuminate\Database\Seeder;
use App\Org;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $org = Org::where('name', '=', 'University of Nebraska at Omaha')->firstOrFail();
        $role = Role::where('name', 'admin')->firstOrFail();

        User::create([ 'org_id' => $org->id, 'name' => 'Sachin Pawaskar', 'password' => '$2y$10$nnx9EERo2lqSNTALfDtfaeXfHUP06phVyDby5lYRlnhgy6tZOLG2O',
            'email' => 'spawaskar@unomaha.edu', 'remember_token' => str_random(60), 'role_id' => $role->id, 'last_login_at' => Carbon::now(),
            'created_by' => 'System', 'updated_by' => 'System']);
    }
}
