<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('users', ['collation' => 'utf8mb4_general_ci']);
        if ($table->exists()) {
            return ;
        }

        $table->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('password', 'char', ['limit' => 60])
            ->addColumn('must_change_password', 'char', ['limit' => 1])
            ->addColumn('profiles_id', 'integer', ['signed' => false])
            ->addColumn('banned', 'char', ['limit' => 1])
            ->addColumn('suspended', 'char', ['limit' => 1])
            ->addColumn('active', 'char', ['limit' => 1, 'default' => null, 'null' => true])
            ->addForeignKey('profiles_id', 'profiles', 'id')
            ->create();
    }
}
