SET FOREIGN_KEY_CHECKS = 0;

 -- -----------------------------------------------------
-- Table `#__redshop_catalog_sample`
-- -----------------------------------------------------

CALL redSHOP_Column_Update('#__redshop_catalog_sample', 'sample_id', 'id', 'INT(11) NOT NULL AUTO_INCREMENT');
CALL redSHOP_Column_Update('#__redshop_catalog_sample', 'sample_name', 'name', 'VARCHAR(100) NOT NULL');
CALL redSHOP_Column_Update('#__redshop_catalog_sample', 'checked_out', 'checked_out', "INT(11) NULL DEFAULT NULL");
CALL redSHOP_Column_Update('#__redshop_catalog_sample', 'checked_out_time', 'checked_out_time', "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `checked_out`");
CALL redSHOP_Column_Update('#__redshop_catalog_sample', 'created_date', 'created_date', "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `checked_out_time`");
CALL redSHOP_Column_Update('#__redshop_catalog_sample', 'created_by', 'created_by', "INT(11) NULL DEFAULT NULL AFTER `created_date`");
CALL redSHOP_Column_Update('#__redshop_catalog_sample', 'modified_by', 'modified_by', "INT(11) NULL DEFAULT NULL AFTER `created_by`");
CALL redSHOP_Column_Update('#__redshop_catalog_sample', 'modified_date', 'modified_date', "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `modified_by`");

SET FOREIGN_KEY_CHECKS = 1;