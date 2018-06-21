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
`{  
   "period_begin":"2013-10-01",
   "facility":"kibabii university clinic",
   "mflcode":"21114",
   "code":"D-CDRR",
   "0":{  
      "drug":"Abacavir (300mg) 60 Tabs",
      "qty_allocated":23
   },
   "1":{  
      "drug":"Abacavir/Lamivudine (60/30mg) 60 FDC Tabs",
      "qty_allocated":21
   },
   "2":{  
      "drug":"Abacavir/Lamivudine (600/300mg) 60 FDC Tabs",
      "qty_allocated":5
   },
   "3":{  
      "drug":"Abacavir/Lamivudine (120/60mg) 60 FDC Tabs",
      "qty_allocated":13
   }
}`
