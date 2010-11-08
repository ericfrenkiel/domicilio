DROP TABLE IF EXISTS postings;

CREATE TABLE postings (
id BIGINT not null AUTO_INCREMENT,
owner_id BIGINT not null,
title varchar(1000),
cost varchar(64),
address varchar(1000),
city varchar(64),
state varchar(32),
info varchar(20000),
fb_album_id BIGINT,
PRIMARY KEY (id)
) ENGINE = MYISAM
	
