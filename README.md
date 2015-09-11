##2015 Myanmar Election Candidate Endopint

Maepaysoh Candidate Endpoint for 2015 Myanmar Election.

Check [Documentation](http://myanmarapi.github.io/endpoints/candidate.html) for avaliable resources from this endpoint.

####Import Data

Put CSV files into `storage/data/` with filename `candidate.csv` and `party.csv`.

Then, you can use the following commands to import the data. 

**Party Data**

	php artisan import:party party.csv
    
**Candidate Data**

	php artisan import:candidate candidate.csv
    
**Drop Collection**

	php artisan iora:drop collection_name
####Technology

Based on [https://github.com/MyanmarAPI/php-endpoint-bootstrap](https://github.com/MyanmarAPI/php-endpoint-bootstrap)
