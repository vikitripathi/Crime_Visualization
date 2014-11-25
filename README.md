Assumptions - 

1. Same Titles have same Urls in Headlines.

Key Features -

1. No on-the-fly joins are performed. Instead table 'Crime_Location' and 'Crime_State' are updated on each new data set entry.(check.php file does this)

2. Crime Locations are first checked for state, this makes the table 'Crime_Location' be used for states as well so table 'Crime_State' becomes redundant.

3. script.php has the utility functions.
