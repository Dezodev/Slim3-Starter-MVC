<?php


use Phinx\Migration\AbstractMigration;

class AddUserTableMigration extends AbstractMigration
{    
    public function change()
    {
        $users = $this->table('users');
        $users->addColumn('username', 'string', ['limit' => 20])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('password', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addIndex(['username', 'email'], ['unique' => true])
            ->save();
    }
}
