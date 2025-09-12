DROP TABLE IF EXISTS auth_identities;
CREATE TABLE auth_identities (
  id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id       BIGINT UNSIGNED NOT NULL,
  provider_type ENUM('google','microsoft','okta','saml','oidc') NOT NULL,
  provider_subject VARCHAR(255) NOT NULL,  -- sub / NameID
  email         VARCHAR(255) NOT NULL,
  email_verified TINYINT(1) NOT NULL DEFAULT 0,
  hd_domain     VARCHAR(255) NULL,  -- Google 'hd' claim when present
  tenant_id     VARCHAR(128) NULL,  -- Microsoft 'tid' (or Okta org id)
  last_login_at DATETIME NULL,
  created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_identity_provider_subject (provider_type, provider_subject),
  KEY idx_identities_user (user_id),
  KEY idx_identities_email (email),
  CONSTRAINT fk_identities_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
