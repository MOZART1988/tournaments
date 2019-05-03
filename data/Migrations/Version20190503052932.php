<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190503052932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'This is migration for team_tournament table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('team_tournament');

        $table->addColumn('team_id', 'integer', ['notnull' => true]);
        $table->addColumn('tournament_id', 'integer', ['notnull' => true]);
        $table->addColumn('group_id', 'integer', ['notnull' => true]);

    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('team_tournament');

    }
}
