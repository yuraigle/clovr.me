CREATE TABLE `ads`
(
    `id`             INT(10)        NOT NULL AUTO_INCREMENT,
    -- `category_id` INT(10)        NULL,
    -- location
    `title`          VARCHAR(100)   NOT NULL,
    `description`    TEXT           NOT NULL,
    `www`            VARCHAR(500)   NULL,
    `youtube`        VARCHAR(100)   NULL,

    `price`          DECIMAL(10, 2) NOT NULL,
    `property_type`  VARCHAR(10)    NULL, -- flat / house / other / garage / parking
    `num_beds`       TINYINT        NULL, --  0-20
    `price_freq`     VARCHAR(10)    NULL, -- per_month / per_week
    `date_avail`     DATE           NULL,
    `room_type`      VARCHAR(10)    NULL, -- single / double / twin / triple / shared / couch
    `room_couples`   TINYINT        NULL,

    `urgent_till`    DATETIME       NULL,
    `featured_till`  DATETIME       NULL,
    `spotlight_till` DATETIME       NULL,
    `created_at`     DATETIME       NOT NULL,
    `deleted_at`     DATETIME       NULL,
    PRIMARY KEY (`id`) USING BTREE
) COLLATE = 'utf8_general_ci'
  ENGINE = MyISAM;
