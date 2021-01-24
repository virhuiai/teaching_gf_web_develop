-- 创建支持中文的表news
CREATE TABLE news (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(128) character set utf8mb4 collate utf8mb4_unicode_ci NOT NULL ,
  slug varchar(128) character set utf8mb4 collate utf8mb4_unicode_ci NOT NULL,
  body text character set utf8mb4 collate utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (id),
  KEY slug (slug)
);