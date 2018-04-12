/*Changes to User Table*/
ALTER TABLE `tbl_user`
CHANGE `name` `firstname` varchar(50) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `id`,
ADD `lastname` varchar(50) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `firstname`,
ADD `email_address` varchar(50) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `lastname`,
CHANGE `phone` `phone_number` varchar(30) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `email_address`,
ADD `password` varchar(128) COLLATE 'latin1_swedish_ci' NOT NULL,
ADD `role_id` int(11) NOT NULL AFTER `password`;

ALTER TABLE `tbl_user`
ADD INDEX `password` (`password`),
ADD UNIQUE `email_address` (`email_address`),
ADD UNIQUE `phone_number` (`phone_number`),
DROP INDEX `name`,
DROP INDEX `phone`;