CREATE DATABASE geolite_countries;

USE geolite_countries;

CREATE TABLE IF NOT EXISTS ip_countries
(
	ipcountryid INT(4) NOT NULL AUTO_INCREMENT,
	startip VARCHAR(200) NOT NULL,
	endip VARCHAR(200) NOT NULL,
	startipnumber BIGINT(8) NOT NULL,
	endipnumber BIGINT(8) NOT NULL,
	countrycode VARCHAR(5) NOT NULL,
	countryname VARCHAR(500) NOT NULL,
	PRIMARY KEY (ipcountryid)
);

CREATE UNIQUE INDEX idx_ip_countries_startip_endip_startipnumber_endipnumber ON ip_countries (startip, endip, startipnumber, endipnumber);