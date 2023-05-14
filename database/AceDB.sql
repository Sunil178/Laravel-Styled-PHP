
-- DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `username` VARCHAR(255) DEFAULT NULL,
  `mobile` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `campaigns`;

CREATE TABLE `campaigns` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `code` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `payment_methods`;

CREATE TABLE `payment_methods` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT NULL,
  `type` VARCHAR(255) DEFAULT NULL COMMENT 'card / paytm / netbanking / mobikwik',
  `identity` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `retention_days`;

CREATE TABLE `retention_days` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `leads`;

CREATE TABLE `leads` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `lead_id` INT unsigned DEFAULT NULL,
  `employee_id` INT unsigned DEFAULT NULL,
  `campaign_id` INT unsigned DEFAULT NULL,
  `state_id` INT unsigned DEFAULT NULL,
  `type` TINYINT DEFAULT NULL COMMENT '0:registration 1:deposit 2:retention_deposit',
  `tracked` TINYINT DEFAULT NULL COMMENT '0:Yes 1:No',
  `emulator` VARCHAR(255) DEFAULT NULL,
  `retention_day_id` INT unsigned DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`),
  FOREIGN KEY (`retention_day_id`) REFERENCES `retention_days` (`id`),
  FOREIGN KEY (`state_id`) REFERENCES `states` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `lead_deposits`;

CREATE TABLE `lead_deposits` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `lead_id` INT unsigned DEFAULT NULL,
  `payment_method_id` INT unsigned DEFAULT NULL,
  `amount` DECIMAL(12, 2) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`),
  FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `gameplays`;

CREATE TABLE `gameplays` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT unsigned DEFAULT NULL,
  `lead_id` INT unsigned DEFAULT NULL,
  `emulator_name` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `gameplay_rakes`;

CREATE TABLE `gameplay_rakes` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `gameplay_id` INT unsigned DEFAULT NULL,
  `rake` DECIMAL(12, 2) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`gameplay_id`) REFERENCES `gameplays` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `targets`;

CREATE TABLE `targets` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT unsigned NOT NULL,
  `campaign_id` INT unsigned NOT NULL,
  `reg_count` INT DEFAULT NULL,
  `reg_state_id` INT unsigned DEFAULT NULL,
  `dep_count` INT DEFAULT NULL,
  `dep_state_id` INT unsigned DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`),
  FOREIGN KEY (`reg_state_id`) REFERENCES `states` (`id`),
  FOREIGN KEY (`dep_state_id`) REFERENCES `states` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `extra_deposits`;

CREATE TABLE `extra_deposits` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `target_id` INT unsigned NOT NULL,
  `count` INT NOT NULL,
  `retention_day_id` INT unsigned DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`target_id`) REFERENCES `targets` (`id`),
  FOREIGN KEY (`retention_day_id`) REFERENCES `retention_days` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `D7_ROI` INT NOT NULL,
  `D14_ROI` INT NOT NULL,
  `D30_ROI` INT NOT NULL,
  `D60_ROI` INT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*
ALTER TABLE `gameplays`
  ADD COLUMN `lead_id` INT unsigned NULL AFTER `employee_id`,
  ADD CONSTRAINT `emulators_ibfk_2` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`);

ALTER TABLE `leads`
  ADD COLUMN `lead_id` INT unsigned NULL AFTER `id`,
  ADD CONSTRAINT `leads_ibfk_5` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`);

ALTER TABLE `leads`
  ADD COLUMN `retention_day_id` INT unsigned NULL AFTER `emulator`,
  ADD CONSTRAINT `leads_ibfk_4` FOREIGN KEY (`retention_day_id`) REFERENCES `retention_days` (`id`);

ALTER TABLE `leads` 
DROP COLUMN `count`;

*/

TRUNCATE TABLE leads;
TRUNCATE TABLE lead_deposits;
TRUNCATE TABLE gameplays;
TRUNCATE TABLE gameplay_rakes;
TRUNCATE TABLE targets;
TRUNCATE TABLE extra_deposits;


