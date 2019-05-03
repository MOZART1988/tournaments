<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190503113505 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Update team_tournament table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('team_tournament');

        $table->addColumn('final_score', 'integer', ['null' => true]);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('team_tournament');

        $table->dropColumn('final_score');
    }
}
