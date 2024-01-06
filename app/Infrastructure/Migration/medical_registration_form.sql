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

CREATE TABLE `medical_registration_form` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `patient_id` bigint,
  `day_of_examination` datetime,
  `reason` varchar(255),
  `user_id` bigint,
  `category_id` bigint,
  `status` varchar(255),
  `created_at` timestamp DEFAULT (now()),
  `updated_at` timestamp DEFAULT (now())
);

CREATE TABLE `category` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `code` varchar(255),
  `name` varchar(255),
  `type` varchar(255),
  `description` varchar(255),
  `created_at` timestamp DEFAULT (now()),
  `updated_at` timestamp DEFAULT (now())
);

ALTER TABLE `medical_registration_form` ADD FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`);

ALTER TABLE `medical_registration_form` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `medical_registration_form` ADD FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

ALTER TABLE `medical_registration_forms` ADD COLUMN `status_id` bigint;

ALTER TABLE `medical_registration_forms` ADD FOREIGN KEY (`status_id`) REFERENCES `status`(`id`);