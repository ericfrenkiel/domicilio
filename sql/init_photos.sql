DROP TABLE IF EXISTS photos;

CREATE TABLE photos (
id BIGINT not null AUTO_INCREMENT,
owner_id BIGINT not null,
title varchar(256),
fb_photo_id BIGINT not null,
PRIMARY KEY (id),
INDEX (fb_photo_id)
) ENGINE = MYISAM
;

