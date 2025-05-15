<?php

return new class implements \App\Database\MigrationInterface
{
    public function up(\PDO $pdo): void
    {
        $sql = '
        SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS books;
        SET FOREIGN_KEY_CHECKS=1;
        CREATE TABLE books (
           id INT AUTO_INCREMENT PRIMARY KEY,
           title VARCHAR(255) NOT NULL,
           year_published INT,
           author_id INT,
           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
           FOREIGN KEY (author_id) REFERENCES authors(id)
        ) ENGINE=InnoDB;
        ';

        $pdo->exec($sql);
    }

    public function down(\PDO $pdo): void
    {
        $sql = '
            SET FOREIGN_KEY_CHECKS=0;
            DROP TABLE IF EXISTS books;
            SET FOREIGN_KEY_CHECKS=1;
        ';

        $pdo->exec($sql);
    }
};
