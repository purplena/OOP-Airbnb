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
-- TABLE TYPE_ESTATE
--
CREATE TABLE IF NOT EXISTS `type_estate` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `label_estate` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `type_estate` (`label_estate`)
VALUES ('House'), ('Appartement'), ('Boat'), ('Camper/RV'), ('Castle'), ('Farm'), ('Cave'), ('Tent');

--
-- TABLE EQUIPMENT
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `label_equipment` VARCHAR(255) NOT NULL,
  `type_equipment` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `equipment` (`label_equipment`, `type_equipment`)
VALUES ('Wifi', 'Essentials'),
('Washer', 'Essentials'),
('Air conditioning', 'Essentials'),
('Kitchen', 'Essentials'),
('Dryer', 'Essentials'),
('Heating', 'Essentials'),
('TV', 'Essentials'),
('Iron', 'Essentials'),
('Dedicated workspace', 'Essentials'),
('Hair dryer', 'Essentials'),
('Pool', 'Features'),
('Free parking', 'Features'),
('EV charger', 'Features'),
('Hot tub', 'Features'),
('Gym', 'Features'),
('BBQ grill', 'Features'),
('Breakfast', 'Features'),
('Smoking allowed', 'Features'),
('Indor fireplace', 'Features'),
('Beachfront', 'Location'),
('Waterfront', 'Location'),
('Ski-in/ski-ou', 'Location'),
('Smoke alarm', 'Safety'),
('Carbon monoxide alarm', 'Safety');

CREATE TABLE IF NOT EXISTS `estate` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `type_estate_id` INT(11) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `size` INT(11) NOT NULL,
  `num_rooms` INT(11) NOT NULL,
  `num_beds` INT(11) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `city` VARCHAR(255) NOT NULL,
  `country` VARCHAR(255) NOT NULL,
  `allowed_animals` BIT,
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`),
  FOREIGN KEY (`type_estate_id`) REFERENCES `type_estate`(`id`),
  PRIMARY KEY (`id`)
);

alter table `estate` modify `allowed_animals` int(3);

ALTER TABLE `estate` MODIFY `description` TEXT;


CREATE TABLE IF NOT EXISTS `photo_estate` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `estate_id` INT(11) NOT NULL,
  `photo_estate_path` VARCHAR(255) NOT NULL,
  FOREIGN KEY (`estate_id`) REFERENCES `estate`(`id`),
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `estate_equipment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `estate_id` INT(11) NOT NULL,
  `equipment_id` INT(11) NOT NULL,
  FOREIGN KEY (`estate_id`) REFERENCES `estate`(`id`),
  FOREIGN KEY (`equipment_id`) REFERENCES `equipment`(`id`),
  PRIMARY KEY (`id`)
);

