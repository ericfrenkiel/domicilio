DROP TABLE IF EXISTS postings;

CREATE TABLE postings (
id BIGINT not null AUTO_INCREMENT,
owner_id BIGINT not null,
title varchar(1000),
cost varchar(64),
bedrooms INT,
address varchar(1000),
city varchar(64),
state varchar(32),
info varchar(20000),
fb_album_id BIGINT,
PRIMARY KEY (id)
) ENGINE = MYISAM
;

insert into postings values (1, 208699, 'Ericplace', 1800, 2, '500 3rd St', 'San Francisco', 'CA', 'awesome place', 17236);
insert into postings values (2, 660659391, 'Nikitas place', 1800, 2, '500 3rd St', 'San Francisco', 'CA', 'awesome place', 17236);
insert into postings values (3, 100000898798374, 'Evgenys place', 1800, 2, '500 3rd St', 'San Francisco', 'CA', 'awesome place', 17236);
