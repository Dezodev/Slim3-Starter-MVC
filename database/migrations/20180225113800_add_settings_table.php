<?php


use Phinx\Migration\AbstractMigration;

class AddSettingsTable extends AbstractMigration
{
    public function change()
    {
        $settings = $this->table('settings');
        $settings->addColumn('name', 'string')
            ->addColumn('value', 'string', ['null' => true])
            ->addColumn('slug', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addIndex(['slug'], ['unique' => true])
            ->save();
    }
}
