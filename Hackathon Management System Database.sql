-- ================================
-- DATABASE
-- ================================
CREATE DATABASE IF NOT EXISTS hackathon_platform;
USE hackathon_platform;

-- ================================
-- USERS (AUTH & ROLES)
-- ================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','participant','judge') NOT NULL,
    status ENUM('active','suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================
-- HACKATHONS
-- ================================
CREATE TABLE hackathons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    submission_deadline DATETIME NOT NULL,
    status ENUM('upcoming','live','closed') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================
-- PARTICIPANTS
-- ================================
CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hackathon_id INT NOT NULL,
    institution VARCHAR(150),
    phone VARCHAR(20),
    approved ENUM('yes','no') DEFAULT 'no',
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (hackathon_id) REFERENCES hackathons(id) ON DELETE CASCADE
);

-- ================================
-- TEAMS
-- ================================
CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hackathon_id INT NOT NULL,
    team_name VARCHAR(100) NOT NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hackathon_id) REFERENCES hackathons(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- ================================
-- TEAM MEMBERS
-- ================================
CREATE TABLE team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT NOT NULL,
    user_id INT NOT NULL,
    role VARCHAR(50),
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ================================
-- PROJECTS
-- ================================
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT NOT NULL,
    project_title VARCHAR(150) NOT NULL,
    description TEXT,
    tech_stack VARCHAR(255),
    github_link VARCHAR(255),
    demo_link VARCHAR(255),
    submitted_at DATETIME,
    status ENUM('draft','submitted','approved') DEFAULT 'draft',
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
);

-- ================================
-- JUDGES
-- ================================
CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    expertise VARCHAR(150),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ================================
-- JUDGING CRITERIA
-- ================================
CREATE TABLE criteria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hackathon_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    max_score INT NOT NULL,
    FOREIGN KEY (hackathon_id) REFERENCES hackathons(id) ON DELETE CASCADE
);

-- ================================
-- SCORES
-- ================================
CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    judge_id INT NOT NULL,
    criteria_id INT NOT NULL,
    score INT NOT NULL,
    feedback TEXT,
    scored_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (judge_id) REFERENCES judges(id) ON DELETE CASCADE,
    FOREIGN KEY (criteria_id) REFERENCES criteria(id) ON DELETE CASCADE
);

-- ================================
-- ANNOUNCEMENTS
-- ================================
CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hackathon_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hackathon_id) REFERENCES hackathons(id) ON DELETE CASCADE
);
