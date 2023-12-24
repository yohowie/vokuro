<?php


use Phinx\Seed\AbstractSeed;

class ProfilesSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Administrators',
                'active' => 'Y',
            ],
            [
                'id' => 2,
                'name' => 'Users',
                'active' => 'Y',
            ],
            [
                'id' => 3,
                'name' => 'Read-Only',
                'active' => 'Y',
            ],
        ];

        $posts = $this->table('profiles');
        $posts->insert($data)->save();
    }
}
