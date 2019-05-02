<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190502113031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'This is migration for game table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('game');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('title', 'string', ['notnull' => true]);
        $table->addColumn('created_at', 'datetime', ['notnull' => true]);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine', 'InnoDB');

    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('game');

    }
}
