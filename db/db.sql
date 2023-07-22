CREATE DATABASE bookings;

use bookings;

CREATE TABLE users (
	id INT PRIMARY KEY auto_increment,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
);

CREATE TABLE rooms(
    id INT PRIMARY KEY auto_increment,
    room_name VARCHAR(50) NOT NULL,
    capacity INT NOT NULL,
    description LONGTEXT NOT NULL,
    img_src VARCHAR(255) NOT NULL
);

CREATE TABLE bookings (
    id INT primary key AUTO_INCREMENT,
    booking_date date NOT NULL,
    file_src LONGTEXT NOT NULL,
    userid INT NOT NULL,
    roomid INT NOT NULL,
    CONSTRAINT fk_user_idx FOREIGN KEY (userid)
    REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_room_idx FOREIGN KEY (roomid)
    REFERENCES romms(id) ON DELETE CASCADE
);

--ALTER TABLE bookings AUTO_INCREMENT = 100000



--TRUNCATE TABLE bookings;
--ALTER TABLE bookings AUTO_INCREMENT = 100000