--
-- TABLE USER
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `second_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `photo_user` VARCHAR(255) NULL,
  PRIMARY KEY (`id`)
);

--
-- TABLE ESTATE
--



