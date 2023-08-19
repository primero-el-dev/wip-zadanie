<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230814201458 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', login VARCHAR(180) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, job VARCHAR(255) NOT NULL, testing_systems VARCHAR(255) DEFAULT NULL, report_systems VARCHAR(255) DEFAULT NULL, knows_selenium TINYINT(1) DEFAULT NULL, ide_environments VARCHAR(255) DEFAULT NULL, programming_languages VARCHAR(255) DEFAULT NULL, knows_my_sql TINYINT(1) DEFAULT NULL, project_management_methodologies VARCHAR(255) DEFAULT NULL, knows_scrum TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
    }
}
