DROP TABLE IF EXISTS `pictures`;
DROP TABLE IF EXISTS `ads`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `categories`
(
    `id`   INT(10) UNSIGNED NOT NULL,
    `name` VARCHAR(100)     NOT NULL,
    PRIMARY KEY (`id`) USING BTREE
) COLLATE = 'utf8mb3_general_ci'
  ENGINE = InnoDB;

INSERT INTO `categories` (`id`, `name`)
VALUES (1, 'Property For Sale');

INSERT INTO `categories` (`id`, `name`)
VALUES (2, 'Property To Rent');

INSERT INTO `categories` (`id`, `name`)
VALUES (3, 'Property To Share');

INSERT INTO `categories` (`id`, `name`)
VALUES (4, 'Parking & Garage For Sale');

INSERT INTO `categories` (`id`, `name`)
VALUES (5, 'Parking & Garage To Rent');

CREATE TABLE `users`
(
    `id`                BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`              VARCHAR(255)        NOT NULL,
    `email`             VARCHAR(255)        NOT NULL,
    `email_verified_at` TIMESTAMP           NULL DEFAULT NULL,
    `password`          VARCHAR(255)        NOT NULL,
    `remember_token`    VARCHAR(100)        NULL DEFAULT NULL,
    `created_at`        TIMESTAMP           NULL DEFAULT NULL,
    `updated_at`        TIMESTAMP           NULL DEFAULT NULL,
    `fb_id`             VARCHAR(20)         NULL DEFAULT NULL,
    `phone`             VARCHAR(20)         NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `IX_USERS_EMAIL_UNIQUE` (`email`) USING BTREE
) COLLATE = 'utf8mb3_general_ci'
  ENGINE = InnoDB;

CREATE TABLE `ads`
(
    `id`             BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`        BIGINT(20) UNSIGNED NOT NULL,
    `category_id`    INT(10) UNSIGNED    NOT NULL,
    `title`          VARCHAR(100)        NOT NULL,
    `price`          DECIMAL(10, 2)      NOT NULL,
    `property_type`  VARCHAR(10)         NULL, -- flat / house / other / garage / parking
    `num_beds`       INT                 NULL, --  0-20
    `price_freq`     VARCHAR(10)         NULL, -- per_month / per_week
    `date_avail`     DATE                NULL,
    `room_type`      VARCHAR(10)         NULL, -- single / double / twin / triple / shared / couch
    `room_couples`   INT                 NULL,
    `www`            VARCHAR(500)        NULL,
    `youtube`        VARCHAR(100)        NULL,
    `description`    TEXT                NULL,
    `lng`            DECIMAL(21, 18)     NULL,
    `lat`            DECIMAL(21, 18)     NULL,
    `location`       VARCHAR(250)        NULL,
    `postcode`       VARCHAR(10)         NULL,
    `county`         VARCHAR(50)         NULL,
    `town`           VARCHAR(100)        NULL,
    `pic`            VARCHAR(14)         NULL,
    `created_at`     DATETIME            NOT NULL DEFAULT NOW(),
    `archived_at`    DATETIME            NULL,
    `deleted_at`     DATETIME            NULL,
    `active_till`    DATE                NULL,
    `urgent_till`    DATE                NULL,
    `featured_till`  DATE                NULL,
    `spotlight_till` DATE                NULL,
    PRIMARY KEY (`id`) USING BTREE,
    CONSTRAINT FOREIGN KEY `FK_AD_ON_CATEGORY` (`category_id`) REFERENCES `categories` (`id`)
        ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT FOREIGN KEY `FK_AD_ON_USER` (`user_id`) REFERENCES `users` (`id`)
        ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX `IX_ADS_USER` (`user_id`) USING BTREE,
    INDEX `IX_ADS_CATEGORY` (`category_id`) USING BTREE
) COLLATE = 'utf8mb3_general_ci'
  ENGINE = InnoDB
  AUTO_INCREMENT = 1649173518;

CREATE TABLE `pictures`
(
    `id`    BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `ad_id` BIGINT(20) UNSIGNED NOT NULL,
    `name`  VARCHAR(14)         NOT NULL,
    `ord`   INT                 NULL,
    PRIMARY KEY (`id`) USING BTREE,
    CONSTRAINT `FK_PICTURE_ON_AD` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`)
        ON UPDATE RESTRICT ON DELETE CASCADE,
    INDEX `IX_PICTURES_AD` (`ad_id`) USING BTREE
) COLLATE = 'utf8mb3_general_ci'
  ENGINE = InnoDB;

CREATE TABLE `password_resets`
(
    `email`      VARCHAR(255) NOT NULL,
    `token`      VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP    NULL DEFAULT NULL,
    INDEX `IX_PASSWORD_RESETS_EMAIL` (`email`) USING BTREE
) COLLATE = 'utf8mb3_general_ci'
  ENGINE = InnoDB;
