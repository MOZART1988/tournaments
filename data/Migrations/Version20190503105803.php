<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190503105803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Update Game table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('game');

        $table->addColumn('stage_id', 'integer', ['notnull' => true]);
        $table->addColumn('first_team_id', 'integer', ['notnull' => true]);
        $table->addColumn('second_team_id', 'integer', ['notnull' => true]);
        $table->addColumn('first_team_score', 'integer', ['null' => true]);
        $table->addColumn('second_team_score', 'integer', ['null' => true]);

    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('game');

        $table->dropColumn('stage_id');
        $table->dropColumn('first_team_id');
        $table->dropColumn('second_team_id');
        $table->dropColumn('first_team_score');
        $table->dropColumn('second_team_score');
    }
}
