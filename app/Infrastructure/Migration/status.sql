CREATE TABLE `status` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `code` varchar(255),
  `type` varchar(255),
  `description` text,
  `created_at` timestamp DEFAULT (now()),
  `updated_at` timestamp DEFAULT (now())
);

ALTER TABLE `users` ADD FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);