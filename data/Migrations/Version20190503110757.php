<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190503110757 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Update game table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('game');

        $table->addColumn('tournament_id', 'integer', ['notnull' => true]);

    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('game');

        $table->dropColumn('tournament_id');
    }
}
