ALTER TABLE `tbl_product_inventory`
  DROP `fk_product_category_id`,
  DROP `fk_product_type_id`,
  DROP `fk_product_price_id`;


ALTER TABLE `tbl_product_inventory` ADD `channel_type` VARCHAR(100) NULL DEFAULT NULL AFTER `fk_product_id`;

DROP TABLE `tbl_bottle_size`, `tbl_bottle_type`, `tbl_flavour`, `tbl_product`, `tbl_product_category`, `tbl_product_type`;

ALTER TABLE `tbl_product_price`
  DROP `fk_product_category_id`,
  DROP `fk_product_type_id`;

ALTER TABLE `tbl_product_master`
  DROP `batch_no`;

  ALTER TABLE `tbl_product_master`
  DROP `purchase_price`,
  DROP `MRP`,
  DROP `selling_price`;

  ALTER TABLE `tbl_product_master` ADD `fk_product_types_id` BIGINT NULL DEFAULT NULL AFTER `fk_stock_availability_id`;
