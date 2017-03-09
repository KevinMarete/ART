/*National MOS*/
CREATE OR REPLACE VIEW vw_national_mos AS
    SELECT 
        CONCAT_WS('(', d.name,CONCAT(d.pack_size, ')')) AS drug,
        pm.period_month AS data_month,
        pm.period_year AS data_year,
        IFNULL(ROUND(SUM(fs.total)/fn_get_national_amc(pm.drug_id, CONCAT(CONCAT_WS('-', pm.period_year, DATE_FORMAT(str_to_date(pm.period_month,'%b'), '%m')), '-01')),1),0) AS facility_mos,
        IFNULL(ROUND(pm.soh_total/fn_get_national_amc(pm.drug_id, CONCAT(CONCAT_WS('-', pm.period_year, DATE_FORMAT(str_to_date(pm.period_month,'%b'), '%m')), '-01')),1),0) AS cms_mos,
        IFNULL(ROUND(pm.supplier_total/fn_get_national_amc(pm.drug_id, CONCAT(CONCAT_WS('-', pm.period_year, DATE_FORMAT(str_to_date(pm.period_month,'%b'), '%m')), '-01')),1),0) AS supplier_mos
    FROM tbl_national_mos pm
    INNER JOIN tbl_drug d ON d.id = pm.drug_id
    INNER JOIN tbl_facility_soh fs ON fs.drug_id = pm.drug_id AND fs.period_month = pm.period_month AND fs.period_year = pm.period_year
    GROUP BY drug, data_month, data_year;


/*Facility Consumption*/
CREATE OR REPLACE VIEW vw_facility_consumption AS
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

/*Facility Patient Regimen*/
CREATE OR REPLACE VIEW vw_facility_patient_regimen AS
    SELECT 
        'Adult ART' AS regimen_category,
        r.code AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    WHERE r.code  LIKE 'A%'
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total
    UNION
    SELECT 
        'Paediatric ART' AS regimen_category,
        r.code AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    WHERE r.code  LIKE 'C%'
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total
    UNION
    SELECT 
        'PEP Adult' AS regimen_category,
        r.code AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    WHERE r.code  LIKE 'PA%'
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total
    UNION
    SELECT 
        'PEP Child' AS regimen_category,
        r.code AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    WHERE r.code  IN ('PC1A', 'PC3A', 'PC4X')
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total
    UNION
    SELECT 
        'PMTCT Child' AS regimen_category,
        r.code AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    WHERE r.code  IN ('PC6', 'PC7', 'PC8', 'PC9', 'PC1X')
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total
    UNION
    SELECT 
        'PMTCT Mother' AS regimen_category,
        r.code AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    WHERE r.code LIKE 'PM%'
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total
    UNION
    SELECT 
        'OI:Universal prophylaxis' AS regimen_category,
        r.code AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    WHERE r.code IN('OI1A', 'OI1C', 'OI2A', 'OI2C')
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total
    UNION
    SELECT 
        'OI:IPT' AS regimen_category,
        r.code AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    WHERE r.code IN('OI4AN', 'OI4CN')
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total
    UNION
    SELECT 
        'OI:Fluconazole(treatment & prophylaxis)' AS regimen_category,
        r.code AS regimen,
        f.name AS facility,
        c.name AS county,
        cs.name AS sub_county,
        rp.period_month AS data_month,
        rp.period_year AS data_year,
        SUM(rp.total) AS total
    FROM tbl_regimen_patient rp
    INNER JOIN tbl_regimen r ON rp.regimen_id = r.id
    INNER JOIN tbl_facility f ON rp.facility_id = f.id
    INNER JOIN tbl_facility_master fm ON fm.id = f.master_id
    INNER JOIN tbl_county_sub cs ON cs.id = fm.county_sub_id
    INNER JOIN tbl_county c ON c.id = cs.county_id
    WHERE r.code IN('OI5A', 'OI5C')
    GROUP by regimen_category,regimen,facility,county,sub_county,data_month,data_year,total;