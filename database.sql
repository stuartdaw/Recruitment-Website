-- SQL Sample data

CREATE TABLE posts (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(128) NOT NULL,
  content text NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY created_at (created_at)
)

--
-- Sample data
--

INSERT INTO posts (title, content) VALUES
('First post', 'This is a really interesting post.'),
('Second post', 'This is a fascinating post!'),
('Third post', 'This is a very informative post.');


-- Table structure for table users
--

CREATE TABLE users (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY `email` (`email`)
);


CREATE TABLE `remembered_logins` (
                                     `token_hash` varchar(64) NOT NULL,
                                     `user_id` int(11) NOT NULL,
                                     `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `remembered_logins`
    ADD PRIMARY KEY (`token_hash`),
    ADD KEY `user_id` (`user_id`);

ALTER TABLE `remembered_logins`
    ADD CONSTRAINT `fk1_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

