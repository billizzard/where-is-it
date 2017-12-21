-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "user" -------------------------------------
-- CREATE TABLE "user" -----------------------------------------
CREATE TABLE `user` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`name` VarChar( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`email` VarChar( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`password` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`access_token` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`auth_key` VarChar( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`role` Smallint( 6 ) NULL DEFAULT '0',
	`created_at` Int( 11 ) NULL,
	`updated_at` Int( 11 ) NULL,
	`login` VarChar( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`is_deleted` TinyInt( 1 ) NULL DEFAULT '0',
	`avatar` VarChar( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	PRIMARY KEY ( `id` ),
	CONSTRAINT `login` UNIQUE( `login` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 5;
-- -------------------------------------------------------------
-- ---------------------------------------------------------


-- Dump data of "user" -------------------------------------
INSERT INTO `user`(`id`,`name`,`email`,`password`,`access_token`,`auth_key`,`role`,`created_at`,`updated_at`,`login`,`is_deleted`,`avatar`) VALUES ( '4', NULL, 'admin@gmail.com', '$2y$13$Mh4qTqu1gYcbDYPtUQZWiuz9BmcgsmKmKKXShMCoUOYjkiLx66Z8K', NULL, NULL, '0', NULL, NULL, 'admin', '0', NULL );
-- ---------------------------------------------------------


-- CREATE INDEX "email" ------------------------------------
-- CREATE INDEX "email" ----------------------------------------
CREATE INDEX `email` USING BTREE ON `user`( `email` );
-- -------------------------------------------------------------
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


