<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePermissionsTable extends AbstractMigration
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
        $table = $this->table('permissions', ['collation' => 'utf8mb4_general_ci']);
        if ($table->exists()) {
            return ;
        }

        $table->addColumn('profiles_id', 'integer')
            ->addColumn('resource', 'string', ['limit' => 255])
            ->addColumn('action', 'string', ['limit' => 255])
            ->addIndex('profiles_id')
            ->create();
    }
}
