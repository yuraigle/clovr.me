DROP TABLE IF EXISTS `ads`;
DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories`
(
    `id`   INT          NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`) USING BTREE
) COLLATE = 'utf8_general_ci'
  ENGINE = MyISAM;

CREATE TABLE `ads`
(
    `id`             INT            NOT NULL AUTO_INCREMENT,
    `category_id`    INT            NOT NULL,
    `title`          VARCHAR(100)   NOT NULL,
    `price`          DECIMAL(10, 2) NOT NULL,
    `property_type`  VARCHAR(10)    NULL, -- flat / house / other / garage / parking
    `num_beds`       INT            NULL, --  0-20
    `price_freq`     VARCHAR(10)    NULL, -- per_month / per_week
    `date_avail`     DATE           NULL,
    `room_type`      VARCHAR(10)    NULL, -- single / double / twin / triple / shared / couch
    `room_couples`   INT            NULL,
    `youtube`        VARCHAR(100)   NULL,
    `www`            VARCHAR(500)   NULL,
    `description`    TEXT           NULL,
    `location`       VARCHAR(100)   NULL, -- ??
    `created_at`     DATETIME       NOT NULL DEFAULT NOW(),
    `deleted_at`     DATETIME       NULL,
    `urgent_till`    DATETIME       NULL,
    `featured_till`  DATETIME       NULL,
    `spotlight_till` DATETIME       NULL,
    PRIMARY KEY (`id`) USING BTREE,
    CONSTRAINT FOREIGN KEY `FK_AD_ON_CATEGORY` (`category_id`) REFERENCES `categories`.`id`
        ON DELETE RESTRICT ON UPDATE RESTRICT
) COLLATE = 'utf8_general_ci'
  ENGINE = MyISAM;

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
