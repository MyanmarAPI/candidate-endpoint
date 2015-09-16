##2015 Myanmar Election Candidate Endopint

Maepaysoh Candidate Endpoint for 2015 Myanmar Election.

Check [Documentation](http://myanmarapi.github.io/endpoints/candidate.html) for avaliable resources from this endpoint.

####Import Data

##### With CSV

Put CSV files into `storage/data/` with filename `candidate.csv` and `party.csv`.

Then, you can use the following commands to import the data. 

**Party Data**

	php artisan import:party party.csv
    
**Candidate Data**

	php artisan import:candidate candidate.csv

##### With JSON

Put JSON files into `storage/data/` with filename `candidate.json` and `party.json`.

Then, you can use the following commands to import the data. 

    php artisan mongo:import candidate
    php artisan mongo:import party

If you data json file name is not `candidate.json` and `party.json`,
used `collection` option argument for import.
    
    // Eg: Import candidate data from candidate_latest.json
    php artisan mongo:import candidate_latest --collection candidate
    // Or shortcut --collection with -c
    php artisan mongo:import candidate_latest -c candidate

    
**Drop Collection**

	php artisan iora:drop collection_name
    
####Technology

Based on [https://github.com/MyanmarAPI/php-endpoint-bootstrap](https://github.com/MyanmarAPI/php-endpoint-bootstrap)
