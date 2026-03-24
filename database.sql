-- Create Database
-- =========================
-- STUDENTS TABLE
-- =========================
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample Student
INSERT INTO students (name, email, password)
VALUES ('Test Student', 'student@gmail.com', '123');

-- =========================
-- COMPANIES TABLE
-- =========================
CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample Companies
INSERT INTO companies (name, location, description) VALUES
('Infosys', 'Pune', 'IT Services Company'),
('TCS', 'Mumbai', 'Software Company'),
('Wipro', 'Bangalore', 'Technology Company');

-- =========================
-- JOBS TABLE
-- =========================
CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT,
    title VARCHAR(100),
    type ENUM('internship','placement'),
    salary VARCHAR(50),
    location VARCHAR(100),
    duration VARCHAR(50),
    last_date DATE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

-- Sample Jobs
INSERT INTO jobs (company_id, title, type, salary, location, duration, last_date, description) VALUES
(1, 'Frontend Developer Intern', 'internship', '8000', 'Remote', '3 Months', '2025-12-31', 'Work on frontend'),
(2, 'Backend Developer', 'placement', '5 LPA', 'Pune', 'Full Time', '2025-12-31', 'Backend development'),
(3, 'Data Analyst Intern', 'internship', '9000', 'Mumbai', '4 Months', '2025-12-31', 'Data analysis role');

-- =========================
-- APPLICATIONS TABLE
-- =========================
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    job_id INT,
    status ENUM('Pending','Selected','Rejected') DEFAULT 'Pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
);

-- Sample Application
INSERT INTO applications (student_id, job_id, status)
VALUES (1, 1, 'Pending');