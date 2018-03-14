<?php


use Phinx\Migration\AbstractMigration;

class AddMediasTable extends AbstractMigration
{

    public function change()
    {
        $medias = $this->table('medias');
        $medias->addColumn('name', 'string')
            ->addColumn('path', 'string', ['null' => true])
            ->addColumn('mimetype', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->save();
    }
}
