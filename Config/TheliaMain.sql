
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- top_product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `top_product`;

CREATE TABLE `top_product`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `element_key` VARCHAR(255),
    `element_id` INTEGER,
    `product_id` INTEGER,
    `selection_code` VARCHAR(255),
    `position` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `top_product_fi_0f5ed8` (`product_id`),
    CONSTRAINT `top_product_fk_0f5ed8`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
