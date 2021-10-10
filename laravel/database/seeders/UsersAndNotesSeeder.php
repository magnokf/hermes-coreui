<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\RoleHierarchy;

class UsersAndNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfUsers = 10;
        $usersIds = array();
        $statusIds = array();
        $userStatus = array(
            'Active',
            'Inactive',
            'Pending',
            'Banned'
        );
        /* Create roles */
        $adminRole = $roleAdmin = Role::create(['name' => 'admin']);
        RoleHierarchy::create([
            'role_id' => $adminRole->id,
            'hierarchy' => 1,
        ]);
        $diretorRole = Role::create(['name' => 'diretor']);
        RoleHierarchy::create([
            'role_id' => $diretorRole->id,
            'hierarchy' => 2,
        ]);
        $pologestorRole = Role::create(['name' => 'pologestor']);
        RoleHierarchy::create([
            'role_id' => $pologestorRole->id,
            'hierarchy' => 3,
        ]);
        $instrutorRole = Role::create(['name' => 'instrutor']);
        RoleHierarchy::create([
            'role_id' => $instrutorRole->id,
            'hierarchy' => 4,
        ]);
        $userRole = Role::create(['name' => 'user']);
        RoleHierarchy::create([
            'role_id' => $userRole->id,
            'hierarchy' => 5,
        ]);
        $guestRole = Role::create(['name' => 'guest']);
        RoleHierarchy::create([
            'role_id' => $guestRole->id,
            'hierarchy' => 6,
        ]);

        $faker = Faker::create();
        /*  insert status  */
        DB::table('status')->insert([
            'name' => 'em andamento',
            'class' => 'primary',
        ]);
        array_push($statusIds, DB::getPdo()->lastInsertId());
        DB::table('status')->insert([
            'name' => 'interrompido',
            'class' => 'secondary',
        ]);
        array_push($statusIds, DB::getPdo()->lastInsertId());
        DB::table('status')->insert([
            'name' => 'completada',
            'class' => 'success',
        ]);
        array_push($statusIds, DB::getPdo()->lastInsertId());
        DB::table('status')->insert([
            'name' => 'expirado',
            'class' => 'warning',
        ]);
        array_push($statusIds, DB::getPdo()->lastInsertId());
        /*  insert admin user   */
        $user = User::create([
            'name' => 'admin',
            'samaccountname' => '1111',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'menuroles' => 'user,admin',
            'status' => 'Active'
        ]);
        $user->assignRole('user');
        $user->assignRole($roleAdmin);
        for($i = 0; $i<$numberOfUsers; $i++){
            $a = array('diretor','instrutor','pologestor');
            $n = 1;
            $user = User::create([
                'name' => $faker->name(),
                'samaccountname'=>$faker->unique()->numberBetween(5555,50000),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'menuroles' => array_rand(array_flip($a), $n),
                'status' => $userStatus[ random_int(0,count($userStatus) - 1) ]
            ]);
            $user->assignRole('user');
            array_push($usersIds, $user->id);
        }

    }
}
