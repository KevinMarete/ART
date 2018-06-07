-- Adminer 4.6.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DELIMITER ;;

DROP FUNCTION IF EXISTS `fn_get_national_amc`;;
CREATE FUNCTION `fn_get_national_amc`(pm_drug_id integer, pm_period_date date) RETURNS int(10)
    DETERMINISTIC
BEGIN
    DECLARE amc INT(10);

    SELECT (SUM(total)/6) INTO amc 
    FROM tbl_consumption
    WHERE DATE_FORMAT(STR_TO_DATE(CONCAT_WS('-', period_year, period_month), '%Y-%b'), '%Y-%m-01') >= DATE_SUB(pm_period_date, INTERVAL 6 MONTH)
    AND DATE_FORMAT(STR_TO_DATE(CONCAT_WS('-', period_year, period_month), '%Y-%b'), '%Y-%m-01') <= pm_period_date
    AND drug_id = pm_drug_id;

    RETURN (amc);
END;;

DROP PROCEDURE IF EXISTS `proc_add_datadate_dsh_mos_table`;;
CREATE PROCEDURE `proc_add_datadate_dsh_mos_table`()
BEGIN
    CREATE TABLE dsh_mos AS
    SELECT 
        IFNULL(ROUND(SUM(fs.total)/fn_get_national_amc(k.drug_id, DATE_FORMAT(str_to_date(CONCAT(k.period_year,k.period_month),'%Y%b%d'),'%Y-%m-01') ),1),0) AS facility_mos,
        IFNULL(ROUND(k.soh_total/fn_get_national_amc(k.drug_id, DATE_FORMAT(str_to_date(CONCAT(k.period_year,k.period_month),'%Y%b%d'),'%Y-%m-01') ),1),0) AS cms_mos,
        IFNULL(ROUND(k.supplier_total/fn_get_national_amc(k.drug_id, DATE_FORMAT(str_to_date(CONCAT(k.period_year,k.period_month),'%Y%b%d'),'%Y-%m-01')),1),0) AS supplier_mos,
        k.period_year AS data_year,
        k.period_month AS data_month,
        STR_TO_DATE(CONCAT_WS('-', k.period_year, k.period_month, '01'),'%Y-%b-%d') AS data_date,
        d.name AS drug
    FROM tbl_kemsa k
    INNER JOIN tbl_stock fs ON fs.drug_id = k.drug_id AND fs.period_month = k.period_month AND fs.period_year = k.period_year
    INNER JOIN vw_drug_list d ON d.id = k.drug_id
    GROUP BY d.name, k.period_month, k.period_year;
END;;

DROP PROCEDURE IF EXISTS `proc_create_dashboard_tables`;;
CREATE PROCEDURE `proc_create_dashboard_tables`()
BEGIN
    SET @@foreign_key_checks = 0;
    
    TRUNCATE dsh_mos;
    INSERT INTO dsh_mos(facility_mos, cms_mos, supplier_mos, data_year, data_month, drug)
    SELECT 
        IFNULL(ROUND(SUM(fs.total)/fn_get_national_amc(k.drug_id, DATE_FORMAT(str_to_date(CONCAT(k.period_year,k.period_month),'%Y%b%d'),'%Y-%m-01') ),1),0) AS facility_mos,
        IFNULL(ROUND(k.soh_total/fn_get_national_amc(k.drug_id, DATE_FORMAT(str_to_date(CONCAT(k.period_year,k.period_month),'%Y%b%d'),'%Y-%m-01') ),1),0) AS cms_mos,
        IFNULL(ROUND(k.supplier_total/fn_get_national_amc(k.drug_id, DATE_FORMAT(str_to_date(CONCAT(k.period_year,k.period_month),'%Y%b%d'),'%Y-%m-01')),1),0) AS supplier_mos,
        k.period_year,
        k.period_month,
        d.name
    FROM tbl_kemsa k
    INNER JOIN tbl_stock fs ON fs.drug_id = k.drug_id AND fs.period_month = k.period_month AND fs.period_year = k.period_year
    INNER JOIN vw_drug_list d ON d.id = k.drug_id
    GROUP BY d.name, k.period_month, k.period_year;
    
    TRUNCATE dsh_consumption;
    INSERT INTO dsh_consumption(total, data_year, data_month, data_date, sub_county, county, facility, drug)
    SELECT 
        SUM(cf.total) AS total,
        cf.period_year AS data_year,
        cf.period_month AS data_month,
        STR_TO_DATE(CONCAT_WS('-', cf.period_year, cf.period_month, '01'),'%Y-%b-%d') AS data_date,
        cs.name AS sub_county,
        c.name AS county,
        f.name AS facility,
        d.name AS drug
    FROM tbl_consumption cf 
    INNER JOIN vw_drug_list d ON cf.drug_id = d.id
    INNER JOIN tbl_facility f ON cf.facility_id = f.id
    INNER JOIN tbl_subcounty cs ON cs.id = f.subcounty_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    GROUP by drug,facility,county,sub_county,data_month,data_year;
    
    TRUNCATE dsh_patient;
    INSERT INTO dsh_patient(total, data_year, data_month, data_date, sub_county, county, facility, partner, regimen, age_category, regimen_service, regimen_line, nnrti_drug, nrti_drug, regimen_category)
    SELECT
        SUM(rp.total) AS total,
        rp.period_year AS data_year,
        rp.period_month AS data_month,
        STR_TO_DATE(CONCAT_WS('-', rp.period_year, rp.period_month, '01'),'%Y-%b-%d') AS data_date,
        cs.name AS sub_county,
        c.name AS county,
        f.name AS facility,
        p.name AS partner,
        CONCAT_WS(' | ', r.code, r.name) AS regimen,
        CASE 
            WHEN ct.name LIKE '%adult%' OR ct.name LIKE '%mother%' THEN 'adult' 
            WHEN ct.name LIKE '%paediatric%' OR ct.name  LIKE '%child%' THEN 'paed'
            ELSE NULL
        END AS age_category,
        s.name AS regimen_service,
        l.name AS regimen_line,
        nn.name AS nnrti_drug,
        n.name AS nrti_drug,
        ct.name AS regimen_category
    FROM tbl_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_service s ON s.id = r.service_id
    INNER JOIN tbl_line l ON l.id = r.line_id
    INNER JOIN tbl_category ct ON ct.id = r.category_id
    LEFT JOIN tbl_nrti n ON n.regimen_id = r.id
    LEFT JOIN tbl_nnrti nn ON nn.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    LEFT JOIN tbl_partner p ON p.id = f.partner_id
    INNER JOIN tbl_subcounty cs ON cs.id = f.subcounty_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    GROUP by regimen_category,nrti_drug,nnrti_drug,regimen_line,regimen_service,age_category,regimen,facility,county,sub_county,data_month,data_year;
    
    TRUNCATE dsh_site;
    INSERT INTO dsh_site(facility, county, subcounty, partner, installed, version, internet, active_patients, coordinator, backup)
    SELECT 
        f.name facility,
        c.name county,
        sb.name subcounty,
        p.name partner,
        IF(i.id IS NOT NULL, 'yes', 'no') installed,
        i.version,
        IF(i.is_internet = 1, 'yes', 'no') internet,
        i.active_patients,
        u.name coordinator,
        IF(b.id IS NOT NULL, 'yes', 'no') backup
    FROM tbl_facility f 
    INNER JOIN tbl_subcounty sb ON sb.id = f.subcounty_id
    INNER JOIN tbl_county c ON c.id = sb.county_id
    INNER JOIN tbl_partner p ON p.id = f.partner_id
    LEFT JOIN tbl_install i ON f.id = i.facility_id
    LEFT JOIN tbl_backup b ON b.facility_id = f.id
    LEFT JOIN tbl_user u ON u.id = i.user_id
    WHERE f.category LIKE '%central%';
    SET @@foreign_key_checks = 1;
END;;

DROP PROCEDURE IF EXISTS `proc_create_dsh_tables_excel`;;
CREATE PROCEDURE `proc_create_dsh_tables_excel`()
BEGIN
    SET @@foreign_key_checks = 0;
    
    TRUNCATE dsh_mos;
    INSERT INTO dsh_mos(facility_mos, cms_mos, supplier_mos, data_year, data_month, data_date, drug)
    SELECT 
        IFNULL(ROUND(SUM(fs.total)/fn_get_national_amc(k.drug_id, DATE_FORMAT(str_to_date(CONCAT(k.period_year,k.period_month),'%Y%b%d'),'%Y-%m-01') ),1),0) AS facility_mos,
        IFNULL(ROUND(k.soh_total/fn_get_national_amc(k.drug_id, DATE_FORMAT(str_to_date(CONCAT(k.period_year,k.period_month),'%Y%b%d'),'%Y-%m-01') ),1),0) AS cms_mos,
        IFNULL(ROUND(k.supplier_total/fn_get_national_amc(k.drug_id, DATE_FORMAT(str_to_date(CONCAT(k.period_year,k.period_month),'%Y%b%d'),'%Y-%m-01')),1),0) AS supplier_mos,
        k.period_year,
        k.period_month,
        STR_TO_DATE(CONCAT_WS('-', k.period_year, k.period_month, '01'),'%Y-%b-%d') AS data_date,
        d.name
    FROM tbl_kemsa k
    INNER JOIN tbl_stock fs ON fs.drug_id = k.drug_id AND fs.period_month = k.period_month AND fs.period_year = k.period_year
    INNER JOIN vw_drug_list d ON d.id = k.drug_id
    GROUP BY d.name, k.period_month, k.period_year;
    
    TRUNCATE dsh_consumption;
    INSERT INTO dsh_consumption(total, data_year, data_month, data_date, sub_county, county, facility, drug)
    SELECT 
        SUM(cf.total) AS total,
        cf.period_year AS data_year,
        cf.period_month AS data_month,
        STR_TO_DATE(CONCAT_WS('-', cf.period_year, cf.period_month, '01'),'%Y-%b-%d') AS data_date,
        cs.name AS sub_county,
        c.name AS county,
        f.name AS facility,
        d.name AS drug
    FROM tbl_consumption cf 
    INNER JOIN vw_drug_list d ON cf.drug_id = d.id
    INNER JOIN tbl_facility f ON cf.facility_id = f.id
    INNER JOIN tbl_subcounty cs ON cs.id = f.subcounty_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    GROUP by drug,facility,county,sub_county,data_month,data_year;
    
    TRUNCATE dsh_patient;
    INSERT INTO dsh_patient(total, data_year, data_month, data_date, sub_county, county, facility, partner, regimen, age_category, regimen_service, regimen_line, nnrti_drug, nrti_drug, regimen_category)
    SELECT
        SUM(rp.total) AS total,
        rp.period_year AS data_year,
        rp.period_month AS data_month,
        STR_TO_DATE(CONCAT_WS('-', rp.period_year, rp.period_month, '01'),'%Y-%b-%d') AS data_date,
        cs.name AS sub_county,
        c.name AS county,
        f.name AS facility,
        p.name AS partner,
        CONCAT_WS(' | ', r.code, r.name) AS regimen,
        CASE 
            WHEN ct.name LIKE '%adult%' OR ct.name LIKE '%mother%' THEN 'adult' 
            WHEN ct.name LIKE '%paediatric%' OR ct.name  LIKE '%child%' THEN 'paed'
            ELSE NULL
        END AS age_category,
        s.name AS regimen_service,
        l.name AS regimen_line,
        nn.name AS nnrti_drug,
        n.name AS nrti_drug,
        ct.name AS regimen_category
    FROM tbl_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_service s ON s.id = r.service_id
    INNER JOIN tbl_line l ON l.id = r.line_id
    INNER JOIN tbl_category ct ON ct.id = r.category_id
    LEFT JOIN tbl_nrti n ON n.regimen_id = r.id
    LEFT JOIN tbl_nnrti nn ON nn.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    LEFT JOIN tbl_partner p ON p.id = f.partner_id
    INNER JOIN tbl_subcounty cs ON cs.id = f.subcounty_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    GROUP by regimen_category,nrti_drug,nnrti_drug,regimen_line,regimen_service,age_category,regimen,facility,county,sub_county,data_month,data_year;
    
    TRUNCATE dsh_site;
    INSERT INTO dsh_site(facility, county, subcounty, partner, installed, version, internet, active_patients, coordinator, backup)
    SELECT 
        f.name facility,
        c.name county,
        sb.name subcounty,
        p.name partner,
        IF(i.id IS NOT NULL, 'yes', 'no') installed,
        i.version,
        IF(i.is_internet = 1, 'yes', 'no') internet,
        i.active_patients,
        u.name coordinator,
        IF(b.id IS NOT NULL, 'yes', 'no') backup
    FROM tbl_facility f 
    INNER JOIN tbl_subcounty sb ON sb.id = f.subcounty_id
    INNER JOIN tbl_county c ON c.id = sb.county_id
    INNER JOIN tbl_partner p ON p.id = f.partner_id
    LEFT JOIN tbl_install i ON f.id = i.facility_id
    LEFT JOIN tbl_backup b ON b.facility_id = f.id
    LEFT JOIN tbl_user u ON u.id = i.user_id
    WHERE f.category LIKE '%central%'
    GROUP BY f.id;
    SET @@foreign_key_checks = 1;
END;;

DROP PROCEDURE IF EXISTS `proc_save_adt_patient`;;
CREATE PROCEDURE `proc_save_adt_patient`(
    IN patient_number VARCHAR(100),
	IN patient_dob DATE,
	IN patient_gender VARCHAR(6),
	IN startheight INT(3),
	IN startweight INT(3),
	IN startbsa DECIMAL(10,4),
	IN currentheight INT(3),
	IN currentweight INT(3),
	IN currentbsa DECIMAL(10,4),
	IN enrollmentdate DATE,
	IN startregimendate DATE,
	IN statuschangedate DATE,
	IN facilitycode VARCHAR(20),
	IN startregimencode VARCHAR(10),
	IN currentregimencode VARCHAR(10),
	IN servicename VARCHAR(20),
	IN statusname VARCHAR(50)
    )
BEGIN
    DECLARE facility, startregimen, currentregimen, service, status INT DEFAULT NULL;

    SELECT id INTO facility FROM tbl_facility WHERE UPPER(mflcode) = UPPER(facilitycode);
    SELECT id INTO startregimen FROM tbl_regimen WHERE UPPER(code) = UPPER(startregimencode);
    SELECT id INTO currentregimen FROM tbl_regimen WHERE UPPER(code) = UPPER(currentregimencode);
    SELECT id INTO service FROM tbl_service WHERE UPPER(name) = UPPER(servicename);
    SELECT id INTO status FROM tbl_status WHERE UPPER(name) = UPPER(statusname);

    IF NOT EXISTS(SELECT * FROM tbl_patient_adt WHERE ccc_number = patient_number AND facility_id = facility) THEN
        INSERT INTO tbl_patient_adt(ccc_number, birth_date, gender, start_height, start_weight, start_bsa, current_height, current_weight, current_bsa, enrollment_date, start_regimen_date, status_change_date, facility_id, start_regimen_id, current_regimen_id, service_id, status_id) VALUES(patient_number, patient_dob, patient_gender, startheight, startweight, startbsa, currentheight, currentweight, currentbsa, enrollmentdate, startregimendate, statuschangedate, facility, startregimen, currentregimen, service, status);
    ELSE
        UPDATE tbl_patient_adt SET birth_date = patient_dob, gender = patient_gender, start_height = startheight, start_weight = startweight, start_bsa = startbsa, current_height = currentheight, current_weight = currentweight, current_bsa = currentbsa, enrollment_date = enrollmentdate, start_regimen_date = startregimendate, status_change_date = statuschangedate, facility_id = facility, start_regimen_id = startregimen, current_regimen_id = currentregimen, service_id = service, status_id = status  WHERE ccc_number = patient_number AND facility_id = facility;
    END IF;
END;;

DROP PROCEDURE IF EXISTS `proc_save_adt_viral`;;
CREATE PROCEDURE `proc_save_adt_viral`(
    IN testid INT(11), 
    IN testdate DATE,
    IN testresult VARCHAR(100),
    IN testjustification TEXT,
    IN patient_number VARCHAR(100),
    IN facility_code VARCHAR(20)
    )
BEGIN
    DECLARE adt_id, facility INT DEFAULT NULL;

    SELECT id INTO facility FROM tbl_facility WHERE UPPER(mflcode) = UPPER(facility_code);
    SELECT id INTO adt_id FROM tbl_patient_adt WHERE UPPER(ccc_number) = UPPER(patient_number) AND facility_id = facility;

    IF NOT EXISTS(SELECT * FROM tbl_viral WHERE test_id = testid) THEN
        INSERT INTO tbl_viral(test_id, test_date, test_result, test_justification, patient_adt_id, ccc_number) VALUES(testid, testdate, testresult, testjustification, adt_id, patient_number);
    ELSE
        UPDATE tbl_viral SET test_date = testdate, test_result = testresult, test_justification = testjustification, patient_adt_id = adt_id, ccc_number = patient_number  WHERE test_id = testid;
    END IF;
END;;

DROP PROCEDURE IF EXISTS `proc_save_adt_visit`;;
CREATE PROCEDURE `proc_save_adt_visit`(
    IN dispensingdate DATE, 
    IN appointmentdate DATE,
    IN appointmentadherence DECIMAL,
    IN patient_number VARCHAR(100),
    IN purposename VARCHAR(30),
    IN lastregimencode VARCHAR(10),
    IN currentregimencode VARCHAR(10),
    IN changereasonname VARCHAR(150),
    IN visitquantity INT(11),
    IN visitduration INT(11),
    IN pillcountadh DECIMAL,
    IN selfreportingadh DECIMAL,
    IN dosename VARCHAR(10),
    IN drugname VARCHAR(255),
    IN packsizevalue VARCHAR(20),
    IN facility_code VARCHAR(20)
    )
BEGIN
    DECLARE visit, item, adt_id, facility, purpose, lastregimen, currentregimen, changereason, dose, drug INT DEFAULT NULL;

    SELECT id INTO facility FROM tbl_facility WHERE UPPER(mflcode) = UPPER(facility_code);
    SELECT id INTO adt_id FROM tbl_patient_adt WHERE UPPER(ccc_number) = UPPER(patient_number) AND facility_id = facility;
    SELECT id INTO purpose FROM tbl_purpose WHERE UPPER(name) = UPPER(purposename);
    SELECT id INTO lastregimen FROM tbl_regimen WHERE UPPER(code) = UPPER(lastregimencode);
    SELECT id INTO currentregimen FROM tbl_regimen WHERE UPPER(code) = UPPER(currentregimencode);
    SELECT id INTO changereason FROM tbl_change_reason WHERE UPPER(name) = UPPER(changereasonname);
    SELECT id INTO visit FROM tbl_visit WHERE patient_adt_id = adt_id AND dispensing_date = dispensingdate;

    IF(visit IS NULL) THEN
        INSERT INTO tbl_visit(dispensing_date, appointment_date, appointment_adherence, patient_adt_id, purpose_id, last_regimen_id, current_regimen_id, change_reason_id) VALUES(dispensingdate, appointmentdate, appointmentadherence, adt_id, purpose, lastregimen, currentregimen, changereason);
        SET visit = LAST_INSERT_ID();
    ELSE
        UPDATE tbl_visit SET appointment_date = appointmentdate, appointment_adherence = appointmentadherence, purpose_id = purpose, last_regimen_id = lastregimen, current_regimen_id = currentregimen, change_reason_id = changereason WHERE id = visit;
    END IF;

    SELECT id INTO dose FROM tbl_dose WHERE UPPER(name) = UPPER(dosename);
    SELECT id INTO drug FROM vw_drug_list WHERE UPPER(name) = UPPER(drugname) AND UPPER(pack_size) = UPPER(packsizevalue);
    SELECT id INTO item FROM tbl_visit_item WHERE visit_id = visit AND drug_id = drug AND UPPER(drug_name) = UPPER(drugname);

    IF(item IS NULL) THEN
        INSERT INTO tbl_visit_item(quantity, duration, pill_count_adherence, self_reporting_adherence, visit_id, dose_id, drug_id, drug_name, packsize) VALUES(visitquantity, visitduration, pillcountadh, selfreportingadh, visit, dose, drug, drugname, packsizevalue);
    ELSE
        UPDATE tbl_visit_item SET quantity = visitquantity, duration = visitduration, pill_count_adherence = pillcountadh, self_reporting_adherence = selfreportingadh, visit_id = visit, dose_id = dose, drug_id = drug, drug_name = drugname, packsize = packsizevalue WHERE id = visit;
    END IF;
END;;

DROP PROCEDURE IF EXISTS `proc_save_cdrr`;;
CREATE PROCEDURE `proc_save_cdrr`()
BEGIN
	
	UPDATE tbl_order o INNER JOIN tbl_facility f ON f.dhiscode = o.facility SET o.facility = f.id;

	
	UPDATE tbl_order o SET o.period = DATE_FORMAT(STR_TO_DATE(o.period, '%Y%m') , "%Y-%m-01");

	
	REPLACE INTO tbl_cdrr(status, created, code, period_begin, period_end, facility_id) SELECT 'pending' status, NOW() created, 'F-CDRR' code, o.period period_begin, LAST_DAY(o.period) period_end, o.facility facility_id FROM tbl_order o INNER JOIN tbl_facility f ON f.id = o.facility GROUP BY o.facility, o.period;

	
	UPDATE tbl_order o INNER JOIN tbl_cdrr c ON c.facility_id = o.facility AND o.period = c.period_begin SET o.report_id = c.id;

	
	REPLACE INTO tbl_cdrr_log(description, created, user_id, cdrr_id) SELECT 'pending' status, NOW() created, '1' user_id, o.report_id cdrr_id FROM tbl_order o INNER JOIN tbl_facility f ON f.id = o.facility GROUP BY o.facility, o.period;

	
	UPDATE tbl_order o INNER JOIN tbl_dhis_elements de ON de.dhis_code = o.dimension SET o.dimension = de.target_id;

END;;

DROP PROCEDURE IF EXISTS `proc_save_cdrr_item`;;
CREATE PROCEDURE `proc_save_cdrr_item`()
BEGIN
	DECLARE bDone INT;
	DECLARE k VARCHAR(255);
	DECLARE v VARCHAR(255);

	
	DECLARE curs CURSOR FOR  SELECT CONCAT_WS(',', GROUP_CONCAT(DISTINCT o.category SEPARATOR ','), 'cdrr_id', 'drug_id'), CONCAT_WS(',', GROUP_CONCAT(o.value SEPARATOR ','), report_id, dimension) FROM tbl_order o INNER JOIN tbl_facility f ON f.id = o.facility GROUP BY o.report_id, o.dimension;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET bDone = 1;

	OPEN curs;

	SET bDone = 0;
	REPEAT
		FETCH curs INTO k,v;

		SET @sqlv=CONCAT('REPLACE INTO tbl_cdrr_item (', k, ') VALUES (', v, ')');
		PREPARE stmt FROM @sqlv;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;

	UNTIL bDone END REPEAT;

	CLOSE curs;

	TRUNCATE tbl_order;

END;;

DROP PROCEDURE IF EXISTS `proc_save_consumption`;;
CREATE PROCEDURE `proc_save_consumption`(
    IN facility_code VARCHAR(20),
    IN drug_name VARCHAR(255), 
    IN packsize VARCHAR(20),
    IN p_year INT(4),
    IN p_month VARCHAR(3),
    IN consumption_total INT(11)
    )
BEGIN
    DECLARE facility,drug INT DEFAULT NULL;
    SET facility_code = REPLACE(facility_code, "'", "");
    SET drug_name = REPLACE(drug_name, "'", "");

    SELECT id INTO facility FROM tbl_facility WHERE UPPER(mflcode) = UPPER(facility_code);
    SELECT id INTO drug FROM vw_drug_list WHERE UPPER(name) = UPPER(drug_name) AND UPPER(pack_size) = UPPER(packsize);

    IF NOT EXISTS(SELECT * FROM tbl_consumption WHERE period_year = p_year AND period_month = p_month AND facility_id = facility AND drug_id = drug) THEN
        INSERT INTO tbl_consumption(total, period_year, period_month, facility_id, drug_id) VALUES(consumption_total, p_year, p_month, facility, drug);
    ELSE
        UPDATE tbl_consumption SET total = consumption_total WHERE period_year = p_year AND period_month = p_month AND facility_id = facility AND drug_id = drug; 
    END IF;
END;;

DROP PROCEDURE IF EXISTS `proc_save_facility`;;
CREATE PROCEDURE `proc_save_facility`(
    IN facility_code VARCHAR(20), 
    IN facility_name VARCHAR(150),
    IN county_name VARCHAR(30)
    )
BEGIN
    DECLARE county,master,subcounty,facility INT DEFAULT NULL;
    SET facility_name = REPLACE(facility_name, "'", "");
    SET facility_code = REPLACE(facility_code, "'", "");
    SET county_name = REPLACE(county_name, "'", "");

    SELECT id INTO facility FROM tbl_facility WHERE UPPER(mflcode) = UPPER(facility_code);
    IF (facility IS NULL) THEN
        SELECT id INTO county FROM tbl_county WHERE LOWER(name) = LOWER(county_name);
        SELECT id INTO subcounty FROM tbl_subcounty WHERE county_id = county LIMIT 1;
        INSERT INTO tbl_facility(name, mflcode, subcounty_id) VALUES(facility_name, facility_code, subcounty);
    END IF;
END;;

DROP PROCEDURE IF EXISTS `proc_save_kemsa`;;
CREATE PROCEDURE `proc_save_kemsa`(
    IN drug_name VARCHAR(255), 
    IN packsize VARCHAR(20),
    IN p_year INT(4),
    IN p_month VARCHAR(3),
    IN issue INT(11),
    IN soh INT(11),
    IN supplier INT(11),
    IN received INT(11)
    )
BEGIN
    DECLARE drug INT DEFAULT NULL;
    SET drug_name = REPLACE(drug_name, "'", "");

    SELECT id INTO drug FROM vw_drug_list WHERE UPPER(name) = UPPER(drug_name) AND UPPER(pack_size) = UPPER(packsize);

    IF NOT EXISTS(SELECT * FROM tbl_kemsa WHERE period_year = p_year AND period_month = p_month AND drug_id = drug) THEN
        INSERT INTO tbl_kemsa(issue_total, soh_total, supplier_total, received_total, period_year, period_month, drug_id) VALUES(issue, soh, supplier, received, p_year, p_month, drug);
    ELSE
        UPDATE tbl_kemsa SET issue_total = issue, soh_total = soh, supplier_total = supplier, received_total = received WHERE period_year = p_year AND period_month = p_month AND drug_id = drug; 
    END IF;
END;;

DROP PROCEDURE IF EXISTS `proc_save_maps`;;
CREATE PROCEDURE `proc_save_maps`()
BEGIN
	
	UPDATE tbl_order o INNER JOIN tbl_facility f ON f.dhiscode = o.facility SET o.facility = f.id;

	
	UPDATE tbl_order o SET o.period = DATE_FORMAT(STR_TO_DATE(o.period, '%Y%m') , "%Y-%m-01");

	
	REPLACE INTO tbl_maps(status, created, code, period_begin, period_end, facility_id) SELECT 'pending' status, NOW() created, 'F-MAPS' code, o.period period_begin, LAST_DAY(o.period) period_end, o.facility facility_id FROM tbl_order o INNER JOIN tbl_facility f ON f.id = o.facility GROUP BY o.facility, o.period;

	
	UPDATE tbl_order o INNER JOIN tbl_maps m ON m.facility_id = o.facility AND o.period = m.period_begin SET o.report_id = m.id;

	
	REPLACE INTO tbl_maps_log(description, created, user_id, maps_id) SELECT 'pending' status, NOW() created, '1' user_id, o.report_id maps_id FROM tbl_order o INNER JOIN tbl_facility f ON f.id = o.facility GROUP BY o.facility, o.period;

	
	UPDATE tbl_order o INNER JOIN tbl_dhis_elements de ON de.dhis_code = o.dimension SET o.dimension = de.target_id;

END;;

DROP PROCEDURE IF EXISTS `proc_save_maps_item`;;
CREATE PROCEDURE `proc_save_maps_item`()
BEGIN
	DECLARE bDone INT;
	DECLARE k VARCHAR(255);
	DECLARE v VARCHAR(255);

	
	DECLARE curs CURSOR FOR  SELECT CONCAT_WS(',', GROUP_CONCAT(DISTINCT o.category SEPARATOR ','), 'maps_id', 'regimen_id'), CONCAT_WS(',', GROUP_CONCAT(o.value SEPARATOR ','), report_id, dimension) FROM tbl_order o INNER JOIN tbl_facility f ON f.id = o.facility GROUP BY o.report_id, o.dimension;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET bDone = 1;

	OPEN curs;

	SET bDone = 0;
	REPEAT
		FETCH curs INTO k,v;

		SET @sqlv=CONCAT('REPLACE INTO tbl_maps_item (', k, ') VALUES (', v, ')');
		PREPARE stmt FROM @sqlv;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;

	UNTIL bDone END REPEAT;

	CLOSE curs;

	TRUNCATE tbl_order;
END;;

DROP PROCEDURE IF EXISTS `proc_save_patient`;;
CREATE PROCEDURE `proc_save_patient`(
    IN facility_code VARCHAR(20), 
    IN regimen_code VARCHAR(6),
    IN patient_total INT(11),
    IN p_month VARCHAR(3),
    IN p_year INT(4)
    )
BEGIN
    DECLARE facility,regimen INT DEFAULT NULL;
    SET facility_code = REPLACE(facility_code, "'", "");
    SET regimen_code = REPLACE(regimen_code, "'", "");

    SELECT id INTO facility FROM tbl_facility WHERE UPPER(mflcode) = UPPER(facility_code);
    SELECT id INTO regimen FROM tbl_regimen WHERE UPPER(code) = UPPER(regimen_code);

    IF NOT EXISTS(SELECT * FROM tbl_patient WHERE period_year = p_year AND period_month = p_month AND regimen_id = regimen AND facility_id = facility) THEN
        INSERT INTO tbl_patient(total, period_year, period_month, regimen_id, facility_id) VALUES(patient_total, p_year, p_month, regimen, facility);
    ELSE
        UPDATE tbl_patient SET total = patient_total WHERE period_year = p_year AND period_month = p_month AND regimen_id = regimen AND facility_id = facility;
    END IF;
END;;

DROP PROCEDURE IF EXISTS `proc_save_stock`;;
CREATE PROCEDURE `proc_save_stock`(
    IN facility_code VARCHAR(20),
    IN drug_name VARCHAR(255), 
    IN packsize VARCHAR(20),
    IN p_year INT(4),
    IN p_month VARCHAR(3),
    IN soh_total INT(11)
    )
BEGIN
    DECLARE facility,drug INT DEFAULT NULL;
    SET facility_code = REPLACE(facility_code, "'", "");
    SET drug_name = REPLACE(drug_name, "'", "");

    SELECT id INTO facility FROM tbl_facility WHERE UPPER(mflcode) = UPPER(facility_code);
    SELECT id INTO drug FROM vw_drug_list WHERE UPPER(name) = UPPER(drug_name) AND UPPER(pack_size) = UPPER(packsize);

    IF NOT EXISTS(SELECT * FROM tbl_stock WHERE period_year = p_year AND period_month = p_month AND facility_id = facility AND drug_id = drug) THEN
        INSERT INTO tbl_stock(total, period_year, period_month, facility_id, drug_id) VALUES(soh_total, p_year, p_month, facility, drug);
    ELSE
        UPDATE tbl_stock SET total = soh_total WHERE period_year = p_year AND period_month = p_month AND facility_id = facility AND drug_id = drug; 
    END IF;
END;;

DROP PROCEDURE IF EXISTS `proc_update_dsh_adt`;;
CREATE PROCEDURE `proc_update_dsh_adt`()
BEGIN
    
    UPDATE dsh_patient_adt p INNER JOIN vw_regimen_list r ON p.start_regimen LIKE CONCAT(r.code, '%') SET p.start_regimen = r.name;
    
    UPDATE dsh_patient_adt p INNER JOIN vw_regimen_list r ON p.current_regimen LIKE CONCAT(r.code, '%') SET p.current_regimen = r.name;
    
    UPDATE dsh_patient_adt p INNER JOIN vw_regimen_list r ON p.current_regimen = r.name SET p.service = r.service;
    
    UPDATE dsh_patient_adt p SET p.service = 'OI Only' WHERE p.current_regimen LIKE '%OI%';
    
    UPDATE dsh_patient_adt p INNER JOIN tbl_status st ON st.name LIKE CONCAT('%', p.status, '%') SET p.status = st.name;
    
    UPDATE dsh_patient_adt p SET p.status = 'LOST TO FOLLOW-UP' WHERE DATEDIFF(CURDATE(), p.pharmacy_appointment_date) >= 90 AND p.status IS NULL;
    
    UPDATE dsh_patient_adt p SET p.status = 'ACTIVE' WHERE DATEDIFF(CURDATE(), p.pharmacy_appointment_date) < 90 AND p.status IS NULL;
    
    UPDATE dsh_patient_adt p SET p.enrollment_date = p.start_regimen_date WHERE p.enrollment_date = '0000-00-00';
    
    UPDATE dsh_patient_adt p SET p.start_regimen_date= p.enrollment_date WHERE p.start_regimen_date = '0000-00-00';
    
    UPDATE dsh_patient_adt p SET p.status_change_date= p.start_regimen_date WHERE p.status_change_date = '0000-00-00';
    
    UPDATE dsh_visit_adt v INNER JOIN dsh_patient_adt p ON CONCAT_WS('_', p.ccc_number, p.facility) = v.patient_adt_id SET v.patient_adt_id = p.id;
    
    UPDATE dsh_visit_adt v INNER JOIN vw_regimen_list r ON v.last_regimen LIKE CONCAT(r.code, '%') SET v.last_regimen = r.name;
    
    UPDATE dsh_visit_adt v INNER JOIN vw_regimen_list r ON v.current_regimen LIKE CONCAT(r.code, '%') SET v.current_regimen = r.name;
    
    UPDATE dsh_visit_adt v INNER JOIN tbl_purpose p ON p.name LIKE CONCAT('%', v.purpose, '%') SET v.purpose = p.name;
    
    UPDATE dsh_visit_adt v INNER JOIN tbl_change_reason cr ON cr.name LIKE CONCAT('%', v.regimen_change_reason, '%') SET v.regimen_change_reason = cr.name;
    
    UPDATE dsh_visit_adt v INNER JOIN tbl_generic g ON g.name LIKE CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(v.drug, ' ', 1), ' ', -1), '%') OR abbreviation LIKE CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(v.drug, ' ', 1), ' ', -1), '%') OR CONCAT(name, CONCAT('(', abbreviation, ')')) LIKE CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(v.drug, ' ', 1), ' ', -1), '%') INNER JOIN tbl_drug d ON d.generic_id = g.id AND d.packsize = v.pack_size AND v.drug LIKE CONCAT('%', d.strength, '%' ) INNER JOIN vw_drug_list dl ON dl.id = d.id SET v.drug = dl.name;
END;;

DELIMITER ;

DROP TABLE IF EXISTS `tbl_role_submodule`;
CREATE TABLE `tbl_role_submodule` (
  `role_id` int(11) NOT NULL,
  `submodule_id` int(11) NOT NULL,
  KEY `role_id` (`role_id`),
  KEY `submodule_id` (`submodule_id`),
  CONSTRAINT `tbl_role_submodule_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tbl_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_role_submodule_ibfk_3` FOREIGN KEY (`submodule_id`) REFERENCES `tbl_submodule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_role_submodule` (`role_id`, `submodule_id`) VALUES
(1,	1),
(2,	2),
(3,	2),
(3,	3),
(2,	2),
(2,	4),
(1,	6),
(1,	7),
(1,	8),
(1,	9),
(1,	10),
(1,	11),
(1,	12),
(1,	13),
(1,	14),
(1,	15),
(1,	16),
(1,	17),
(1,	18),
(1,	20);

DROP TABLE IF EXISTS `tbl_submodule`;
CREATE TABLE `tbl_submodule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `tbl_submodule_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `tbl_submodule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_submodule` (`id`, `name`, `module_id`) VALUES
(1,	'county',	1),
(2,	'reports',	2),
(3,	'assign',	2),
(4,	'reporting rates',	2),
(5,	'allocation',	2),
(6,	'subcounty',	1),
(7,	'line',	1),
(8,	'drug',	1),
(9,	'facility',	1),
(10,	'category',	1),
(11,	'partner',	1),
(12,	'generic',	1),
(13,	'regimen',	1),
(14,	'service',	1),
(15,	'purpose',	1),
(16,	'status',	1),
(17,	'dose',	1),
(18,	'change_reason',	1),
(20,	'formulation',	1);

-- 2018-06-07 07:06:43
