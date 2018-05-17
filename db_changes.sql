ALTER TABLE tbl_cdrr_item
ADD qty_allocated int(11) unsigned NULL,
ADD feedback text NULL AFTER qty_allocated,
ADD decision varchar(20) NULL AFTER feedback;


-- 16-05-2018