<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190503053831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add id column for team_tournament';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('team_tournament');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine', 'InnoDB');

    }

    public function down(Schema $schema) : void
    {
        $schema->getTable('team_tournament')->dropColumn('id');
    }
}
