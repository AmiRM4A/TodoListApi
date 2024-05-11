-- ### USERS TABLE ### --
DROP TABLE IF EXISTS `users`;

-- This table stores user information such as name, username, password, email, and login/register details
CREATE TABLE `users`
(
    `id`         INT AUTO_INCREMENT,                             -- Unique ID for the user (auto-incremented)
    `name`       VARCHAR(50) NOT NULL,                           -- Full name of the user (required)
    `user_name`  VARCHAR(20) NOT NULL,                           -- Username of the user (required)
    `password`   VARCHAR(64)  NOT NULL,                           -- Hashed password of the user (required)
    `email`      VARCHAR(120)         DEFAULT NULL,              -- Email address of the user (unique, can be null, max 120 chars)
    `last_login` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Timestamp of the user's last login (defaults to current timestamp)
    `registered_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Timestamp of the user's registration time (defaults to current timestamp)
    `last_ip`    VARCHAR(15) NOT NULL,                           -- IP address from which the user last logged in (required, max 15 chars for IPv4)
    `salt`       VARCHAR(64)  NOT NULL,                           -- Salt used for password hashing (required, unique)

    -- Define keys
    PRIMARY KEY (`id`),                                          -- Primary key constraint for the id column
    UNIQUE KEY `uq_users_username` (`user_name`),                -- Ensure usernames are unique
    UNIQUE KEY `uq_users_email` (`email`),                       -- Ensure email addresses are unique
    UNIQUE KEY `uq_users_salt` (`salt`),                         -- Ensure salt values are unique
    INDEX `idx_users_last_login` (`last_login`)                  -- Index for frequent queries on last_login
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci
    COMMENT = 'Stores user information';

-- ### LOGGED IN TABLE ### --
DROP TABLE IF EXISTS `logged_in`;

-- This table stores information about currently logged-in users and their session tokens
CREATE TABLE `logged_in`
(
    `id`         INT AUTO_INCREMENT,                                                   -- Unique ID for the record (auto-incremented)
    `token`      VARCHAR(255) NOT NULL,                                                -- Session token for the logged-in user (required, unique)
    `user_id`    INT          NOT NULL,                                                -- ID of the user who is logged in (required)
    `expires_at` DATETIME     NOT NULL,                                                -- Expiration timestamp for the session token (required)

    -- Define keys
    PRIMARY KEY (`id`),                                                                -- Primary key constraint for the id column
    UNIQUE KEY `token` (`token`),                                                      -- Ensure uniqueness of session tokens
    CONSTRAINT `fk_logged_in_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`), -- Link to users table
    INDEX `idx_logged_in_expires_at` (`expires_at`)                                    -- Index for frequent queries on expires_at
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci
    COMMENT = 'Stores information about logged-in users';

-- ### TASKS TABLE ### --
DROP TABLE IF EXISTS `tasks`;

-- This table stores information about tasks created by users
CREATE TABLE `tasks`
(
    `id`          INT AUTO_INCREMENT,                                                                           -- Unique ID for the task (auto-incremented)
    `title`       VARCHAR(100)                  NOT NULL,                                                       -- Title of the task (required)
    `description` VARCHAR(255)                  NOT NULL,                                                       -- Description of the task (required)
    `status`      ENUM ('pending', 'completed') NOT NULL DEFAULT 'pending',                                     -- Status of the task (required, default 'pending')
    `created_at`  TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,                             -- Timestamp when the task was created (defaults to current timestamp)
    `updated_at`  TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Timestamp when the task was last updated (required, auto-updated)
    `created_by`  INT                           NOT NULL,                                                       -- ID of the user who created the task (required)

    -- Define keys
    PRIMARY KEY (`id`),                                                                                         -- Primary key constraint for the id column
    INDEX `idx_tasks_status` (`status`),                                                                        -- Index for frequent queries on status
    INDEX `idx_tasks_created_by` (`created_by`),                                                                -- Index for frequent queries on created_by
    CONSTRAINT `fk_tasks_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)                            -- Link to users table
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci
    COMMENT = 'Stores information about tasks created by users';