
-- -----------------------------------------------------
-- Schema zminafon_db
-- -----------------------------------------------------
-- LuckyDress DB
-- DROP SCHEMA IF EXISTS `zminafon_db` ;

-- -----------------------------------------------------
-- Schema zminafon_db
--
-- LuckyDress DB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `zminafon_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `zminafon_db` ;

-- -----------------------------------------------------
-- Table `zminafon_db`.`zf_langs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zminafon_db`.`zf_langs` ;

CREATE TABLE IF NOT EXISTS `zminafon_db`.`zf_langs` (
  `id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(6) NOT NULL,
  `title` VARCHAR(12) NOT NULL,
  `active` ENUM('1', '0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'available languages';

-- -----------------------------------------------------
-- Table `zminafon_db`.`zf_auxiliary_phrases`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zminafon_db`.`zf_auxiliary_phrases` ;

CREATE TABLE IF NOT EXISTS `zminafon_db`.`zf_auxiliary_phrases` (
  `id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_name` VARCHAR(255) NOT NULL,
  `subst_name` VARCHAR(255) NULL DEFAULT NULL,
  `phrase` VARCHAR(255) NOT NULL,
  `edit_date` INT(10) NULL DEFAULT NULL,
  `lang_id` TINYINT(1) UNSIGNED NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  INDEX `fk_zf_auxiliary_phrases_zf_langs1_idx` (`lang_id`),
  CONSTRAINT `fk_zf_auxiliary_phrases_zf_langs1`
    FOREIGN KEY (`lang_id`)
    REFERENCES `zminafon_db`.`zf_langs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'auxiliary phrases used on web-site';

-- -----------------------------------------------------
-- Table `zminafon_db`.`zf_contact_form`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zminafon_db`.`zf_contact_form` ;

CREATE TABLE IF NOT EXISTS `zminafon_db`.`zf_contact_form` (
  `id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` MEDIUMINT(3) NULL DEFAULT NULL,
  `sort_id` TINYINT(3) NULL DEFAULT NULL,
  `field_name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL DEFAULT 'text',
  `label` VARCHAR(255) NULL DEFAULT NULL,
  `title` VARCHAR(255) NULL DEFAULT NULL,
  `placeholder` VARCHAR(255) NULL DEFAULT NULL,
  `edit_date` INT(10) NULL DEFAULT NULL,
  `lang_id` TINYINT(1) UNSIGNED NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  INDEX `fk_zf_contact_form_zf_langs1_idx` (`lang_id`),
  CONSTRAINT `fk_zf_contact_form_zf_langs1`
    FOREIGN KEY (`lang_id`)
    REFERENCES `zminafon_db`.`zf_langs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'fields used in the contact form';

-- -----------------------------------------------------
-- Table `zminafon_db`.`zf_orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zminafon_db`.`zf_orders` ;

CREATE TABLE IF NOT EXISTS `zminafon_db`.`zf_orders` (
  `id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `phone` VARCHAR(255),
  `message` TEXT NOT NULL,
  `add_date` INT(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'all of orders were posted using the form on web-site';

INSERT INTO `zf_langs`(`id`,`name`,`title`,`active`) values (1,'ua','ua','1'),(2,'en','en','1'),(3,'ru','ru','1');
INSERT INTO `zf_contact_form` (`id`,`parent_id`,`sort_id`,`field_name`,`label`,`title`,`placeholder`,`edit_date`,`lang_id`)
VALUES
  -- PL -----------------------------------------------------
  (null,0,1,'name',"Ім'я","Ім'я","Ім'я",UNIX_TIMESTAMP(),1),
  (null,0,2,'email','E-mail','E-mail','E-mail',UNIX_TIMESTAMP(),1),
  (null,0,3,'phone','Номер телефону','Номер телефону','Номер телефону',UNIX_TIMESTAMP(),1),
  (null,0,4,'message','Повідомлення','Повідомлення','Повідомлення',UNIX_TIMESTAMP(),1),
  (null,0,5,'act','відправити','відправити','відправити',UNIX_TIMESTAMP(),1),
  -- EN ----------------------------------------------
  (null,0,1,'name','Your Name','What is your name?','Your Name',UNIX_TIMESTAMP(),2),
  (null,0,2,'email','E-mail','E-mail','E-mail',UNIX_TIMESTAMP(),2),
  (null,0,3,'phone','Phone Number','Please, enter your phone number','Phone Number',UNIX_TIMESTAMP(),2),
  (null,0,4,'message','Message','Your Message','Your Message',UNIX_TIMESTAMP(),2),
  (null,0,5,'act','Send','Send a message','Send',UNIX_TIMESTAMP(),2),
  -- RU ----------------------------------------------
  (null,0,1,'name','Ваше Имя','Укажите Ваше Имя','Ваше Имя',UNIX_TIMESTAMP(),3),
  (null,0,2,'email','E-mail','Укажите Ваш адрес элетронной почты','E-mail',UNIX_TIMESTAMP(),3),
  (null,0,3,'phone','Номер телефона', 'Укажите Ваш номер телефона','Номер телефона',UNIX_TIMESTAMP(),3),
  (null,0,4,'message','Сообщение','Текст Сообщения','Сообщение',UNIX_TIMESTAMP(),3),
  (null,0,5,'act','Отправить','Отправить сообщение','Отправить',UNIX_TIMESTAMP(),3)
;

