CREATE DATABASE speedtestmap;
CREATE USER 'speedtestmap'@'localhost' IDENTIFIED BY '6I20I801hE';
GRANT ALL ON speedtestmap.* TO 'speedtestmap'@'localhost';

USE speedtestmap;

CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    uname varchar(255),
    hash text
);

CREATE TABLE pins (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pinName varchar(255),
    pinColor varchar(255)
);

CREATE TABLE scans (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    marker int,
    dateof varchar(255),
    typeof varchar(255),
    lat varchar(255),
    lon varchar(255),
    down varchar(255),
    up varchar(255),
    ping varchar(255)
);