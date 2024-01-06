CREATE TABLE `fees` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `medical_registration_form_id` bigint NOT NULL,
  `payment_date` datetime,
  `amount` double,
  `status_id` bigint,
  `created_at` timestamp DEFAULT (now()),
  `updated_at` timestamp DEFAULT (now())
);

CREATE TABLE `test_results` (
  `id` bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `fee_id` bigint,
  `medical_history` text,
  `clinical_examination` text,
  `preliminary_examination` text,
  `diagnostic` text,
  `created_at` timestamp DEFAULT (now()),
  `updated_at` timestamp DEFAULT (now())
);

CREATE TABLE `prescriptions` (
  `id` bigint PRIMARY KEY NOT NULL,
  `fee_id` bigint,
  `quantity` int,
  `unit_price` float,
  `unit` varchar(255),
  `instruction` text,
  `created_at` timestamp DEFAULT (now()),
  `updated_at` timestamp DEFAULT (now())
);

CREATE TABLE `prescription_medicines` (
  `medicine_id` bigint,
  `prescription_id` bigint
);

ALTER TABLE `fees` ADD FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`);

ALTER TABLE `fees` ADD FOREIGN KEY (`medical_record_id`) REFERENCES `medical_registration_forms` (`id`);

ALTER TABLE `test_results` ADD FOREIGN KEY (`fee_id`) REFERENCES `fees` (`id`);

ALTER TABLE `prescriptions` ADD FOREIGN KEY (`fee_id`) REFERENCES `fees` (`id`);

ALTER TABLE `prescription_medicines` ADD FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`);

ALTER TABLE `prescription_medicines` ADD FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

ALTER  table fees 
drop foreign key fees_ibfk_2,
add constraint fees_medical_form_fee foreign key (medical_registration_form_id) references medical_registration_forms(id) on delete cascade;

ALTER  table test_results  
drop foreign key test_results_ibfk_1,
add constraint fees_test_result_fee foreign key (fee_id) references fees(id) on delete cascade;

ALTER TABLE fees ADD COLUMN type varchar(255);