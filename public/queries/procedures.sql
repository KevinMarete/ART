/*Site Ordering*/
DELIMITER //
CREATE OR REPLACE PROCEDURE proc_save_site_ordering(
    IN facility_code VARCHAR(30), 
    IN facility_name VARCHAR(150),
    IN county_name VARCHAR(30)
    )
BEGIN
    DECLARE county,master,subcounty,facility INT DEFAULT NULL;
    SET facility_name = REPLACE(facility_name, "'", "");
    SET county_name = REPLACE(county_name, "'", "");
    SELECT id INTO county FROM tbl_county WHERE name LIKE CONCAT('%', county_name , '%');
    SELECT id INTO master FROM tbl_facility_master WHERE code LIKE CONCAT('%', facility_code , '%') AND name LIKE CONCAT('%', facility_name , '%');
    SELECT id INTO facility FROM tbl_facility WHERE name LIKE CONCAT('%', facility_name , '%');
    IF (county IS NULL) THEN 
        INSERT INTO tbl_county(name)VALUES(LOWER(county_name));
        SET county = LAST_INSERT_ID();
    END IF;
    IF (master IS NULL) THEN 
        SELECT sb.id INTO subcounty FROM tbl_county_sub sb INNER JOIN tbl_county c ON c.id = sb.county_id WHERE c.id = county LIMIT 1;
        IF (subcounty IS NULL) THEN 
            INSERT INTO tbl_county_sub(name)VALUES('N/A');
            SET subcounty = LAST_INSERT_ID();
        END IF;
        INSERT INTO tbl_facility_master(code, name, county_sub_id)VALUES(facility_code, LOWER(facility_name), subcounty);
        SET master = LAST_INSERT_ID();
    END IF;
    IF (facility IS NULL) THEN
        INSERT INTO tbl_facility(name, master_id) VALUES(facility_name, master);
    ELSE
        UPDATE tbl_facility SET name = facility_name, master_id = master  WHERE id = facility;
    END IF;
END//
DELIMITER ;

/*Patients Current*/
DELIMITER //
CREATE OR REPLACE PROCEDURE proc_save_patient_current(
	IN facility_name VARCHAR(150), 
	IN regimen_code VARCHAR(6),
	IN patient_total INT(11),
	IN p_month VARCHAR(3),
	IN p_year INT(4)
	)
BEGIN
	DECLARE facility,regimen INT DEFAULT NULL;
    SET facility_name = REPLACE(facility_name, "'", "");
    SELECT id INTO facility FROM tbl_facility WHERE name LIKE CONCAT('%', facility_name , '%');
    SELECT id INTO regimen FROM tbl_regimen WHERE code LIKE CONCAT('%', regimen_code , '%');
    IF (facility IS NULL) THEN 
    	INSERT INTO tbl_facility(name)VALUES(facility_name);
    	SET facility = LAST_INSERT_ID();
    END IF;
    IF (regimen IS NULL) THEN 
    	INSERT INTO tbl_regimen(code)VALUES(regimen_code);
    	SET regimen = LAST_INSERT_ID();
    END IF;
    IF NOT EXISTS(SELECT * FROM tbl_regimen_patient WHERE period_year = p_year AND period_month = p_month AND regimen_id = regimen AND facility_id = facility) THEN
        INSERT INTO tbl_regimen_patient(total, period_year, period_month, regimen_id, facility_id) VALUES(patient_total, p_year, p_month, regimen, facility);
    ELSE
        UPDATE tbl_regimen_patient SET total = patient_total WHERE period_year = p_year AND period_month = p_month AND regimen_id = regimen AND facility_id = facility;
    END IF;
END//
DELIMITER ;


/*National MOS*/
DELIMITER //
CREATE OR REPLACE PROCEDURE proc_save_national_mos(
	IN drug_name VARCHAR(150), 
	IN packsize VARCHAR(10),
	IN p_year INT(4),
	IN p_month VARCHAR(3),
	IN issue INT(10),
    IN soh INT(10),
    IN supplier INT(10),
    IN received INT(10)
	)
BEGIN
	DECLARE drug INT DEFAULT NULL;
    SET drug_name = REPLACE(drug_name, "'", "");
    SELECT id INTO drug FROM tbl_drug WHERE name LIKE CONCAT('%', drug_name , '%') AND pack_size LIKE CONCAT('%', packsize , '%');
    IF (drug IS NULL) THEN 
    	INSERT INTO tbl_drug(name, pack_size)VALUES(drug_name, packsize);
    	SET drug = LAST_INSERT_ID();
    END IF;
    IF NOT EXISTS(SELECT * FROM tbl_national_mos WHERE period_year = p_year AND period_month = p_month AND drug_id = drug) THEN
        INSERT INTO tbl_national_mos(issue_total, soh_total, supplier_total, received_total, period_year, period_month, drug_id) VALUES(issue, soh, supplier, received, p_year, p_month, drug);
    ELSE
        UPDATE tbl_national_mos SET issue_total = issue, soh_total = soh, supplier_total = supplier, received_total = received WHERE period_year = p_year AND period_month = p_month AND drug_id = drug; 
    END IF;
END//
DELIMITER ;

/*Facility Consumption*/
DELIMITER //
CREATE OR REPLACE PROCEDURE proc_save_facility_consumption(
    IN facility_name VARCHAR(150),
    IN drug_name VARCHAR(150), 
    IN packsize VARCHAR(10),
    IN p_year INT(4),
    IN p_month VARCHAR(3),
    IN consumption_total INT(10)
    )
BEGIN
    DECLARE facility,drug INT DEFAULT NULL;
    SET facility_name = REPLACE(facility_name, "'", "");
    SET drug_name = REPLACE(drug_name, "'", "");
    SELECT id INTO facility FROM tbl_facility WHERE name LIKE CONCAT('%', facility_name , '%');
    SELECT id INTO drug FROM tbl_drug WHERE name LIKE CONCAT('%', drug_name , '%') AND pack_size LIKE CONCAT('%', packsize , '%');
    IF (facility IS NULL) THEN 
        INSERT INTO tbl_facility(name)VALUES(facility_name);
        SET facility = LAST_INSERT_ID();
    END IF;
    IF (drug IS NULL) THEN 
        INSERT INTO tbl_drug(name, pack_size)VALUES(drug_name, packsize);
        SET drug = LAST_INSERT_ID();
    END IF;
    IF NOT EXISTS(SELECT * FROM tbl_facility_consumption WHERE period_year = p_year AND period_month = p_month AND facility_id = facility AND drug_id = drug) THEN
        INSERT INTO tbl_facility_consumption(total, period_year, period_month, facility_id, drug_id) VALUES(consumption_total, p_year, p_month, facility, drug);
    ELSE
        UPDATE tbl_facility_consumption SET total = consumption_total WHERE period_year = p_year AND period_month = p_month AND facility_id = facility AND drug_id = drug; 
    END IF;
END//
DELIMITER ;

/*Facility SOH*/
DELIMITER //
CREATE OR REPLACE PROCEDURE proc_save_facility_soh(
    IN facility_name VARCHAR(150),
    IN drug_name VARCHAR(150), 
    IN packsize VARCHAR(10),
    IN p_year INT(4),
    IN p_month VARCHAR(3),
    IN soh_total INT(10)
    )
BEGIN
    DECLARE facility,drug INT DEFAULT NULL;
    SET facility_name = REPLACE(facility_name, "'", "");
    SET drug_name = REPLACE(drug_name, "'", "");
    SELECT id INTO facility FROM tbl_facility WHERE name LIKE CONCAT('%', facility_name , '%');
    SELECT id INTO drug FROM tbl_drug WHERE name LIKE CONCAT('%', drug_name , '%') AND pack_size LIKE CONCAT('%', packsize , '%');
    IF (facility IS NULL) THEN 
        INSERT INTO tbl_facility(name)VALUES(facility_name);
        SET facility = LAST_INSERT_ID();
    END IF;
    IF (drug IS NULL) THEN 
        INSERT INTO tbl_drug(name, pack_size)VALUES(drug_name, packsize);
        SET drug = LAST_INSERT_ID();
    END IF;
    IF NOT EXISTS(SELECT * FROM tbl_facility_soh WHERE period_year = p_year AND period_month = p_month AND facility_id = facility AND drug_id = drug) THEN
        INSERT INTO tbl_facility_soh(total, period_year, period_month, facility_id, drug_id) VALUES(soh_total, p_year, p_month, facility, drug);
    ELSE
        UPDATE tbl_facility_soh SET total = soh_total WHERE period_year = p_year AND period_month = p_month AND facility_id = facility AND drug_id = drug; 
    END IF;
END//
DELIMITER ;

/*Create Dashboard Tables intead of views*/
DELIMITER //
CREATE OR REPLACE PROCEDURE proc_create_dashboard_tables()
BEGIN
    /*National MOS*/
    TRUNCATE tbl_dashboard_mos;
    INSERT INTO tbl_dashboard_mos(drug, data_month, data_year, facility_mos, cms_mos, supplier_mos)
    SELECT 
        CONCAT_WS('(', d.name,CONCAT(d.pack_size, ')')) AS drug,
        pm.period_month AS data_month,
        pm.period_year AS data_year,
        IFNULL(ROUND(fs.total/fn_get_national_amc(pm.drug_id, DATE_FORMAT(str_to_date(CONCAT(CONCAT(pm.period_year,pm.period_month),'01'),'%Y%b%d'),'%Y-%m-%d') ),1),0) AS facility_mos,
        IFNULL(ROUND(pm.soh_total/fn_get_national_amc(pm.drug_id, DATE_FORMAT(str_to_date(CONCAT(CONCAT(pm.period_year,pm.period_month),'01'),'%Y%b%d'),'%Y-%m-%d') ),1),0) AS cms_mos,
        IFNULL(ROUND(pm.supplier_total/fn_get_national_amc(pm.drug_id, DATE_FORMAT(str_to_date(CONCAT(CONCAT(pm.period_year,pm.period_month),'01'),'%Y%b%d'),'%Y-%m-%d')),1),0) AS supplier_mos
    FROM tbl_national_mos pm
    INNER JOIN tbl_drug d ON d.id = pm.drug_id
    INNER JOIN vw_national_soh fs ON fs.drug_id = pm.drug_id AND fs.period_month = pm.period_month AND fs.period_year = pm.period_year
    GROUP BY drug, data_month, data_year;
    /*Facility Consumption*/
    TRUNCATE tbl_dashboard_consumption;
    INSERT INTO tbl_dashboard_consumption(drug, facility, county, sub_county, data_month, data_year, total)
    SELECT 
        CONCAT_WS('(', d.name,CONCAT(d.pack_size, ')')) AS drug,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        cf.period_month AS data_month,
        cf.period_year AS data_year,
        SUM(cf.total) AS total
    FROM tbl_facility_consumption cf 
    INNER JOIN tbl_drug d ON cf.drug_id = d.id
    INNER JOIN tbl_facility f ON cf.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    GROUP by drug,facility,county,sub_county,data_month,data_year,total;
    /*Facility Patients*/
    TRUNCATE tbl_dashboard_patient;
    INSERT INTO tbl_dashboard_patient(regimen_category, drug_base, regimen, facility, county, sub_county, data_month, data_year, total)
    SELECT 
        CASE 
            WHEN r.code  LIKE 'A%' THEN 'Adult ART' 
            WHEN r.code  LIKE 'C%' THEN 'Paediatric ART'
            WHEN r.code  LIKE 'PA%' THEN 'PEP Adult'
            WHEN r.code  IN ('PC1A', 'PC3A', 'PC4X') THEN 'PEP Child'
            WHEN r.code  IN ('PC6', 'PC7', 'PC8', 'PC9', 'PC1X')THEN 'PMTCT Child'
            WHEN r.code LIKE 'PM%' THEN 'PMTCT Mother'
            WHEN r.code IN('OI1A', 'OI1C', 'OI2A', 'OI2C') THEN 'OI:Universal prophylaxis'
            WHEN r.code IN('OI4AN', 'OI4CN') THEN 'OI:IPT'
            WHEN r.code IN('OI5A', 'OI5C') THEN 'OI:Fluconazole(treatment & prophylaxis)'
        END AS regimen_category,
        CASE 
            WHEN mr.name LIKE 'AZT%' THEN 'AZT-Based'
            WHEN mr.name LIKE 'TDF%' THEN 'TDF-Based'
            WHEN mr.name LIKE 'ABC%' THEN 'ABC-Based'
        END AS drug_base,
        CONCAT_WS(' | ', mr.code, mr.name) AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_regimen_master mr ON mr.id = r.master_id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total;
END//
DELIMITER ;