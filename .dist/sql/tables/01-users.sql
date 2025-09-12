DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  email            VARCHAR(255)    NOT NULL,
  email_verified   TINYINT(1)      NOT NULL DEFAULT 0,
  first_name       VARCHAR(255)    NOT NULL,
  last_name        VARCHAR(255)    NOT NULL,
  picture_url      VARCHAR(512)    NULL,
  status           ENUM('invited','active','disabled') NOT NULL DEFAULT 'invited',
  last_login_at    DATETIME        NULL,
  created_at       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at       DATETIME        NULL,

  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email (email),
  KEY idx_users_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (email, email_verified, first_name, last_name, picture_url, status, last_login_at)
VALUES
('anna.jensen@acme-consulting.dk', 1, 'Anna', 'Jensen', NULL, 'active', NOW()),
('mads.olsen@acme-consulting.dk', 1, 'Mads', 'Olsen',   NULL, 'invited', NULL),
('sofia.larsson@nordictalent.se', 1, 'Sofia', 'Larsson', NULL, 'active', NOW()),
('erik.nilsson@nordictalent.se',  1, 'Erik', 'Nilsson',  NULL, 'active', NOW()),
('katrin.schmidt@global-recruiters.de', 1, 'Katrin', 'Schmidt', NULL, 'active', NOW()),
('marco.fischer@global-recruiters.de',  1, 'Marco',  'Fischer', NULL, 'disabled', NULL),
('freelancer@gmail.com', 1, 'Freelancer', 'One', NULL, 'invited', NULL);