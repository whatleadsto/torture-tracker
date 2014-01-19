Documentation for Relations Tracker API
============
This project was conceived at the Rewired State Foreign Commonwealth Hack in 2014. 

This is an API for tracking and qualifying several variables relating to the UK's Diplomatic Relationships. The data is colour coded onto a map giving a visual scale for reflecting the overall strength of the country's relationship with the UK, relative to all other countries. You can select different datasets to include for consideration.

## Installation

- Create new folder in your server route with the github repository in it.
- In PHP MyAdmin, create new database called "rewiredstate".
- Create user with username: rewiredstate password: pass and grant global privileges.
- Import the SQL database: datasets/rewiredstate.sql
- 

## Issues

* Different Datasets use different country names

The datasets provided by the FCO didn't use a universal standard for the names of countries. For example USA, United States, United States of America. This gave our API difficulties in extracting data from different tables.

* Incomplete Datasets i.e. treaties not incleding dates

Some of the datasets provided by the FCO did not include variables that we think would be important. For example, the UK Treaties set did not include the dates the treaties were signed or who the other signatories were. We wrote a scraper to pull what was missing from the online database.


## Extensions

*  Upload to server as standalone web app.

*  Although it would need cleaning before being intruduced to the API there are many more datasets we identified as having potential to impact on the UK's relationships with the World, including: Foreign residents International Students, Travellers etc.

These datasets are available from the FCO or ONS.


* The idea was originally to develop an app capable of demonstrating the value of UK diplomatic efforts through the FCO. It proved difficult to quantify these effects but we wanted to use the normalized FDI data as a proxy for "strength of relationship" on the assumption that having money invested in a country represented some level of trust. We would have liked to use regression values to establish the significance of the data to the FDI and thus develop a scale. We could also build in a cluster analysis to establish the relative worth of traties and memberships of International communities based on the importance of the sigantories and comparable relationships. 

This could of course be upgraded to include a more appropriate dataset if a better way of quantifying the effects of strong relationships were established.

* Not all datasets provided by the FCO included timescales. We would like to extend the API so as to visualize the changing nature of the UK's realtionships with the international community.







