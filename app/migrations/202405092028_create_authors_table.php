<?php

return new class implements \App\Database\MigrationInterface
{
    public function up(\PDO $pdo): void
    {
        $sql = '
            SET FOREIGN_KEY_CHECKS=0;
            DROP TABLE IF EXISTS authors;
            SET FOREIGN_KEY_CHECKS=1;
            CREATE TABLE authors (
                 id INT AUTO_INCREMENT PRIMARY KEY,
                 name VARCHAR(255) NOT NULL,
                 bio TEXT,
                 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ';

        $pdo->exec($sql);
    }

    public function down(\PDO $pdo): void
    {
        $sql = '
            SET FOREIGN_KEY_CHECKS=0;
            DROP TABLE IF EXISTS authors;
            SET FOREIGN_KEY_CHECKS=1;
        ';

        $pdo->exec($sql);
    }
};
