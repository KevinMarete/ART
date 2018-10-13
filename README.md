# ART DASHBOARD

This is the ART Patient and Commodity Dashboard

# API

Endpoint:
------
- URL `http://commodities.nascop.org/API/allocation`

Parameters:
-----------
- mfl `http://commodities.nascop.org/API/allocation`
- period `Reporting period (YYYYMM) e.g. 201801 //Jan 2018`
- app `application userid e.g. kemsa`
- token `base64 string (app:secret) e.g. kemsa:KS2lx0q  ‘a2Vtc2E6S1MybHgwcQ==’`

Request:
---------
- Method `GET`
- URL `http://commodities.nascop.org/API/allocation?mfl=21114&period=201301&token=&user=kemsa&token= a2Vtc2E6S1MybHgwcQ==`

Response:
---------
`{"info":{"period_begin":"2018-06-01","facility":"st mulumba mission hospital","mflcode":"10765","code":"F-CDRR"},"allocation":{"drug":[{"drug":"Abacavir (ABC) 300mg Tabs","qty_allocated":"74"},{"drug":"Atazanavir\/Ritonavir (ATV\/r) 300\/100mg Tabs","qty_allocated":"76"},{"drug":"Dolutegravir (DTG) 50mg Tabs","qty_allocated":"92"},{"drug":"Lamivudine (3TC) 150mg Tabs","qty_allocated":"40"},{"drug":"Lopinavir\/Ritonavir (LPV\/r) 200\/50mg Tabs","qty_allocated":"55"},{"drug":"Nevirapine (NVP) 200mg Tabs","qty_allocated":"30"},{"drug":"Tenofovir\/Lamivudine (TDF\/3TC) 300\/300mg FDC Tabs","qty_allocated":"142"},{"drug":"Tenofovir\/Lamivudine\/Efavirenz (TDF\/3TC\/EFV) 300\/300\/600mg FDC Tabs","qty_allocated":"500"},{"drug":"Zidovudine\/Lamivudine (AZT\/3TC) 300\/150mg FDC Tabs","qty_allocated":"35"}]}}`
