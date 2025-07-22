-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('teacher', 'director', 'academic_director', 'discipline_master') NOT NULL
);

-- Create the attendance table
CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    arrival_time DATETIME,
    departure_time DATETIME,
    date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
