DROP TABLE IF EXISTS authors;
CREATE TABLE authors (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         name VARCHAR(255) NOT NULL,
                         bio TEXT,
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

DROP TABLE IF EXISTS books;
CREATE TABLE books (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       title VARCHAR(255) NOT NULL,
                       year_published INT,
                       author_id INT,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       FOREIGN KEY (author_id) REFERENCES authors(id)
) ENGINE=InnoDB;

INSERT INTO authors (id, name, bio, created_at) VALUES
                                                    (1, 'Robert C. Martin', 'This is an author', '2023-05-19 19:27:18'),
                                                    (2, 'Martin Fowler', 'Martin''s bio', '2023-05-19 19:27:18'),
                                                    (123, 'A. N. Author', 'This is an author', '2023-05-19 19:27:18');

INSERT INTO books (id, title, year_published, author_id, created_at) VALUES
                                                                         (1, 'Clean Code: A Handbook of Agile Software Craftsmanship', 2008, 1, '2023-05-19 19:28:47'),
                                                                         (2, 'Refactoring: Improving the Design of Existing Code', 1999, 2, '2023-05-19 19:28:47'),
                                                                         (999, 'A Test Book', 1999, 123, '2023-05-19 19:28:47');

CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(50) UNIQUE NOT NULL,
                       password VARCHAR(255) NOT NULL,
                       plan VARCHAR(255) NOT NULL
);