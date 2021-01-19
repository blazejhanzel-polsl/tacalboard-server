/* This is initialization script for development database instance. */

DROP TABLE IF EXISTS boards;
DROP TABLE IF EXISTS tags_in_events;
DROP TABLE IF EXISTS users_in_events;
DROP TABLE IF EXISTS events_reminders;
DROP TABLE IF EXISTS calendars_events;
DROP TABLE IF EXISTS calendars;
DROP TABLE IF EXISTS tags_in_tasks;
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS tasks_lists;
DROP TABLE IF EXISTS projects_in_workspaces;
DROP TABLE IF EXISTS workspaces;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS repeatings;
DROP TABLE IF EXISTS users_in_teams;
DROP TABLE IF EXISTS teams;
DROP TABLE IF EXISTS subscriptions;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(32) NOT NULL,
    password VARCHAR(40) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = INNODB;

CREATE TABLE transactions (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    transaction_date TIMESTAMP NOT NULL,
    amount_paid DECIMAL(6,2) NOT NULL,
    transaction_currency CHAR(3),
    transaction_status ENUM('correct','cancelled','in progress') NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE = INNODB;

CREATE TABLE subscriptions (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    date_from TIMESTAMP NOT NULL,
    date_to TIMESTAMP NOT NULL,
    transaction_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id)
) ENGINE = INNODB;

CREATE TABLE teams (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = INNODB;

CREATE TABLE users_in_teams (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    team_id INT NOT NULL,
    role ENUM('owner','member') NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (team_id) REFERENCES teams(id)
) ENGINE = INNODB;

CREATE TABLE repeatings (
    id INT NOT NULL AUTO_INCREMENT,
    monday BOOLEAN NOT NULL,
    tuesday BOOLEAN NOT NULL,
    wednesday BOOLEAN NOT NULL,
    thursday BOOLEAN NOT NULL,
    friday BOOLEAN NOT NULL,
    saturday BOOLEAN NOT NULL,
    sunday BOOLEAN NOT NULL,
    step INT NOT NULL,
    end_date TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE = INNODB;

CREATE TABLE projects (
    id INT NOT NULL AUTO_INCREMENT,
    team_id INT NOT NULL,
    name VARCHAR(32) NOT NULL,
    position INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (team_id) REFERENCES teams(id)
) ENGINE = INNODB;

CREATE TABLE tags (
    id INT NOT NULL AUTO_INCREMENT,
    project_id INT NOT NULL,
    icon VARCHAR(32) NOT NULL,
    name VARCHAR(32) NOT NULL,
    position INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
) ENGINE = INNODB;

CREATE TABLE workspaces (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(32) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE = INNODB;

CREATE TABLE projects_in_workspaces (
    id INT NOT NULL AUTO_INCREMENT,
    project_id INT NOT NULL,
    workspace_id INT NOT NULL,
    position INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (workspace_id) REFERENCES workspaces(id)
) ENGINE = INNODB;

CREATE TABLE tasks_lists (
    id INT NOT NULL AUTO_INCREMENT,
    project_id INT NOT NULL,
    name VARCHAR(32) NOT NULL,
    icon VARCHAR(32) NOT NULL,
    position INT NOT NULL,
    predefined BOOLEAN NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
) ENGINE = INNODB;

CREATE TABLE tasks (
    id INT NOT NULL AUTO_INCREMENT,
    deadline_date TIMESTAMP,
    description VARCHAR(1000),
    done BOOLEAN NOT NULL,
    duration INT NOT NULL,
    position INT NOT NULL,
    priority INT NOT NULL,
    reminder_date TIMESTAMP,
    repeating_id INT,
    tasks_list_id INT NOT NULL,
    title VARCHAR(128) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (repeating_id) REFERENCES repeatings(id),
    FOREIGN KEY (tasks_list_id) REFERENCES tasks_lists(id)
) ENGINE = INNODB;

CREATE TABLE tags_in_tasks (
    id INT NOT NULL AUTO_INCREMENT,
    tag_id INT NOT NULL,
    task_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (tag_id) REFERENCES tags(id),
    FOREIGN KEY (task_id) REFERENCES tasks(id)
) ENGINE = INNODB;

CREATE TABLE calendars (
    id INT NOT NULL AUTO_INCREMENT,
    project_id INT NOT NULL,
    name VARCHAR(32) NOT NULL,
    icon VARCHAR(32) NOT NULL,
    position INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
) ENGINE = INNODB;

CREATE TABLE calendars_events (
    id INT NOT NULL AUTO_INCREMENT,
    calendar_id INT NOT NULL,
    title VARCHAR(64) NOT NULL,
    all_day BOOLEAN NOT NULL,
    start_date TIMESTAMP NOT NULL,
    end_date TIMESTAMP NOT NULL,
    repeating_id INT,
    location VARCHAR(128),
    color CHAR(7),
    description VARCHAR(1000),
    visibility ENUM('private','public') NOT NULL,
    accessibility ENUM('free','busy','pre-approval','unavailable') NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (calendar_id) REFERENCES calendars(id),
    FOREIGN KEY (repeating_id) REFERENCES repeatings(id)
) ENGINE = INNODB;

CREATE TABLE events_reminders (
    id INT NOT NULL AUTO_INCREMENT,
    event_id INT NOT NULL,
    reminder_date TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (event_id) REFERENCES calendars_events(id)
) ENGINE = INNODB;

CREATE TABLE users_in_events (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    role ENUM('organizer','participant') NOT NULL,
    present ENUM('yes','no','maybe') NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES calendars_events(id)
) ENGINE = INNODB;

CREATE TABLE tags_in_events (
    id INT NOT NULL AUTO_INCREMENT,
    tag_id INT NOT NULL, 
    event_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (tag_id) REFERENCES tags(id),
    FOREIGN KEY (event_id) REFERENCES calendars_events(id)
) ENGINE = INNODB;

CREATE TABLE boards (
    id INT NOT NULL AUTO_INCREMENT,
    project_id INT NOT NULL,
    name VARCHAR(32) NOT NULL,
    icon VARCHAR(32) NOT NULL,
    position INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
) ENGINE = INNODB;

INSERT INTO users(email, password)
    VALUES ('admin', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a');
INSERT INTO teams(name)
    VALUES ('Prywatny'), ('Firmowy');
INSERT INTO users_in_teams(user_id, team_id, role)
    VALUES (1, 1, 'owner'), (1, 2, 'owner');
INSERT INTO transactions(user_id, transaction_date, amount_paid, transaction_currency, transaction_status) VALUES
    (1, NOW(), 20.0, 'PLN', 'correct');
INSERT INTO subscriptions(user_id, date_from, date_to, transaction_id)
    VALUES (1, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), 1);
INSERT INTO projects(team_id, name, position)
    VALUES (1, 'Przykładowy projekt', 1);
