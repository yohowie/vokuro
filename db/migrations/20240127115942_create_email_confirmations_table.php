<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEmailConfirmationsTable extends AbstractMigration
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
        $table = $this->table('email_confirmations', ['collation' => 'utf8mb4_general_ci']);
        if ($table->exists()) {
            return ;
        }

        $table->addColumn('users_id', 'integer', ['signed' => false])
            ->addColumn('code', 'char', ['limit' => 32])
            ->addColumn('created_at', 'integer')
            ->addColumn('modified_at', 'integer', ['null' => true])
            ->addColumn('confirmed', 'char', ['limit' => 1, 'default' => 'N'])
            ->addForeignKey('users_id', 'users','id')
            ->create();
    }
}
