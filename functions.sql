/*Pipeline AMC*/
DELIMITER //
CREATE OR REPLACE FUNCTION fn_get_pipeline_amc(pm_drug_id integer, pm_period_date date) RETURNS INT(10)
    DETERMINISTIC
BEGIN
    DECLARE amc INT(10);

    SELECT AVG(total) INTO amc 
    FROM tbl_facility_consumption
	WHERE CONCAT(CONCAT_WS('-', period_year, DATE_FORMAT(str_to_date(period_month,'%b'), '%m')), '-01') >= date_sub(pm_period_date, interval 6 month)
	AND drug_id = pm_drug_id;

 	RETURN (amc);
END//
DELIMITER ;