<?php


use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
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
                'name' => 'Bob Burnquist',
                'email' => 'bob@phalcon.io',
                'password' => '$2y$08$L3Vqdk9ydm9PZktqMWRQO.bjO.rV4a7GJACZKEeCskzxWbT570Z2a', // password1
                'must_change_password' => 'N',
                'profiles_id' => 1,
                'banned' => 'N',
                'suspended' => 'N',
                'active' => 'Y',
            ],
            [
                'id' => 2,
                'name' => 'Erik',
                'email' => 'erik@phalcon.io',
                'password' => '$2y$08$YU16R3VJV2tVQ3ZhYkdPROaeb9Pvem5jvCPsb95/aB8B6T12wB6Qy', // password2
                'must_change_password' => 'N',
                'profiles_id' => 1,
                'banned' => 'N',
                'suspended' => 'N',
                'active' => 'Y',
            ],
            [
                'id' => 3,
                'name' => 'Veronica',
                'email' => 'veronica@phalcon.io',
                'password' => '$2y$08$VHR0Q2FyMDIzUkdpQllrQeSXJUl.H91aLDm/tclX2VGvpqxpFog52', // password3
                'must_change_password' => 'N',
                'profiles_id' => 1,
                'banned' => 'N',
                'suspended' => 'N',
                'active' => 'Y',
            ],
            [
                'id' => 4,
                'name' => 'Yukimi Nagano',
                'email' => 'yukimi@phalcon.io',
                'password' => '$2y$08$Ykw4b0ZNU3VYZUxWRlpEZ.2f0p3OPhjIEVJbh6CGHlYm8XtIeLRqy', // password4
                'must_change_password' => 'N',
                'profiles_id' => 2,
                'banned' => 'N',
                'suspended' => 'N',
                'active' => 'Y',
            ]
        ];

        $posts = $this->table('users');
        $posts->insert($data)
            ->save();
    }
}
