CREATE TABLE `users` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `username` varchar(255),
  `password` varchar(255),
  `name` varchar(255),
  `birthday` varchar(255),
  `phone_numer` varchar(255),
  `address` varchar(255),
  `email` varchar(255),
  `role` varchar(255),
  `status_id` bigint,
  `created_at` timestamp DEFAULT (now()),
  `updated_at` timestamp DEFAULT (now())
);