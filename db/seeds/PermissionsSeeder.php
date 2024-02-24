<?php


use Phinx\Seed\AbstractSeed;

class PermissionsSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'profiles_id' => 3,
                'resource' => 'users',
                'action' => 'index'
            ],
            [
                'id' => 2,
                'profiles_id' => 3,
                'resource' => 'users',
                'action' => 'search'
            ],
            [
                'id' => 3,
                'profiles_id' => 3,
                'resource' => 'profiles',
                'action' => 'index'
            ],
            [
                'id' => 4,
                'profiles_id' => 3,
                'resource' => 'profiles',
                'action' => 'search'
            ],
            [
                'id' => 5,
                'profiles_id' => 1,
                'resource' => 'users',
                'action' => 'index'
            ],
            [
                'id' => 6,
                'profiles_id' => 1,
                'resource' => 'users',
                'action' => 'search'
            ],
            [
                'id' => 7,
                'profiles_id' => 1,
                'resource' => 'users',
                'action' => 'edit'
            ],
            [
                'id' => 8,
                'profiles_id' => 1,
                'resource' => 'users',
                'action' => 'create'
            ],
            [
                'id' => 9,
                'profiles_id' => 1,
                'resource' => 'users',
                'action' => 'delete'
            ],
            [
                'id' => 10,
                'profiles_id' => 1,
                'resource' => 'users',
                'action' => 'changePassword'
            ],
            [
                'id' => 11,
                'profiles_id' => 1,
                'resource' => 'profiles',
                'action' => 'index'
            ],
            [
                'id' => 12,
                'profiles_id' => 1,
                'resource' => 'profiles',
                'action' => 'search'
            ],
            [
                'id' => 13,
                'profiles_id' => 1,
                'resource' => 'profiles',
                'action' => 'edit'
            ],
            [
                'id' => 14,
                'profiles_id' => 1,
                'resource' => 'profiles',
                'action' => 'create'
            ],
            [
                'id' => 15,
                'profiles_id' => 1,
                'resource' => 'profiles',
                'action' => 'delete'
            ],
            [
                'id' => 16,
                'profiles_id' => 1,
                'resource' => 'permissions',
                'action' => 'index'
            ],
            [
                'id' => 17,
                'profiles_id' => 2,
                'resource' => 'users',
                'action' => 'index'
            ],
            [
                'id' => 18,
                'profiles_id' => 2,
                'resource' => 'users',
                'action' => 'search'
            ],
            [
                'id' => 19,
                'profiles_id' => 2,
                'resource' => 'users',
                'action' => 'edit'
            ],
            [
                'id' => 20,
                'profiles_id' => 2,
                'resource' => 'users',
                'action' => 'create'
            ],
            [
                'id' => 21,
                'profiles_id' => 2,
                'resource' => 'profiles',
                'action' => 'index'
            ],
            [
                'id' => 22,
                'profiles_id' => 2,
                'resource' => 'profiles',
                'action' => 'search'
            ],
        ];

        $posts = $this->table('permissions');
        $posts->insert($data)->save();
    }
}
