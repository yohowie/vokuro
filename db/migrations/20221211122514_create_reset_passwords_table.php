<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateResetPasswordsTable extends AbstractMigration
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
        $table = $this->table('reset_passwords', ['collation' => 'utf8mb4_general_ci']);
        if ($table->exists()) {
            return ;
        }

        $table->addColumn('users_id', 'integer')
            ->addColumn('code', 'string', ['limit' => 50])
            ->addColumn('created_at', 'integer', ['null' => true, 'default' => null])
            ->addColumn('modified_at', 'integer', ['null' => true, 'default' => null])
            ->addColumn('reset', 'char', ['limit' => 1])
            ->addIndex(['users_id'])
            ->create();
    }
}
