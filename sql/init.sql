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
location point,
PRIMARY KEY (id)
) ENGINE = MYISAM;

insert into postings values (1, 208699			, 'Eric\'s place', 1800, 2, '500 3rd St', 'San Francisco', 'CA', 'awesome place', GeomFromText('POINT(37.7809910 -122.3955896)'));
insert into postings values (2, 208699		, 'Nikita\'s place', 1800, 1, '674 Bay St.', 'San Francisco', 'CA', 'awesome place', GeomFromText('POINT(37.8051129 -122.4178697)'));
insert into postings values (3, 208699	, 'Evgeny\' place', 1800, 3, '1601 California Ave', 'Palo Alto', 'CA', 'awesome place', GeomFromText('POINT(37.4159670 -122.1517860)'));

#660659391
#100000898798374

DROP TABLE IF EXISTS posting_photos;
create table posting_photos (
        posting_id bigint not null,
        photo_id bigint not null,
        photo_url varchar(4000) not null,
        photo_url_thumbnail varchar(4000) not null
) ENGINE=MYISAM;

insert into posting_photos values (1, 98423808305,
'http://sphotos.ak.fbcdn.net/hphotos-ak-snc1/hs085.snc1/5041_98423808305_40796308305_1960517_6704612_n.jpg',
'http://photos-e.ak.fbcdn.net/hphotos-ak-snc1/hs085.snc1/5041_98423808305_40796308305_1960517_6704612_a.jpg');

insert into posting_photos values (2, 98423808305,
'http://sphotos.ak.fbcdn.net/hphotos-ak-snc1/hs085.snc1/5041_98423808305_40796308305_1960517_6704612_n.jpg',
'http://photos-e.ak.fbcdn.net/hphotos-ak-snc1/hs085.snc1/5041_98423808305_40796308305_1960517_6704612_a.jpg');

insert into posting_photos values (3, 98423808305,
'http://sphotos.ak.fbcdn.net/hphotos-ak-snc1/hs085.snc1/5041_98423808305_40796308305_1960517_6704612_n.jpg',
'http://photos-e.ak.fbcdn.net/hphotos-ak-snc1/hs085.snc1/5041_98423808305_40796308305_1960517_6704612_a.jpg');

DROP TABLE IF EXISTS locations;
create table locations (
	id int not null AUTO_INCREMENT,
	parent_id int not null,
	name VARCHAR(4000) not null,
	type int not null, # 0 - country, 1 state, 2 city, 3 neighborhood
	PRIMARY KEY(id)
) ENGINE = MYISAM;

insert into locations values (1, 0, 'USA', 0);
insert into locations values (2, 1, 'California', 1);
insert into locations values (3, 2, 'San Francisco', 2);
insert into locations values (4, 3, 'Russian Hill', 3);
insert into locations values (5, 3, 'Soma', 3);
insert into locations values (6, 3, 'Pacific Heights', 3);
insert into locations values (7, 2, 'Palo Alto', 3);

drop table if exists posting_location;
create table posting_location (
	posting_id INT not null,
	location_id INT not null,
	UNIQUE (posting_id, location_id)
) ENGINE = MYISAM;

insert into posting_location values (1, 1);
insert into posting_location values (1, 2);
insert into posting_location values (1, 3);
insert into posting_location values (1, 5);

insert into posting_location values (2, 1);
insert into posting_location values (2, 2);
insert into posting_location values (2, 3);
insert into posting_location values (2, 4);

insert into posting_location values (3, 1);
insert into posting_location values (3, 2);
insert into posting_location values (3, 7);


drop table if exists amenities;
create table amenities (
	id int not null AUTO_INCREMENT,
	name VARCHAR(4000),
	searchable boolean,
 	PRIMARY KEY(id)
);

insert into amenities values(1, 'On-Site Laundry', true);
insert into amenities values(2, 'Door Attendant', true);
insert into amenities values(3, 'Parking Space(s)', true);
insert into amenities values(4, 'Fitness Center', true);
insert into amenities values(5, 'Garage', true);
insert into amenities values(6, 'High Speed Internet Available', true);
insert into amenities values(7, 'Limited Access', true);
insert into amenities values(8, 'Wheelchair Access', true);
insert into amenities values(9, 'Whirlpool(s)', true);
insert into amenities values(10, 'Hardwood Floor', true);

drop table if exists posting_amenity;
create table posting_amenity (
	posting_id INT not null,
	amenity_id INT not null,
 	UNIQUE(posting_id, amenity_id)
);

insert into posting_amenity values (1, 1);
insert into posting_amenity values (1, 2);
insert into posting_amenity values (1, 3);
insert into posting_amenity values (1, 4);
insert into posting_amenity values (1, 5);
insert into posting_amenity values (1, 6);
insert into posting_amenity values (1, 7);
insert into posting_amenity values (1, 8);

insert into posting_amenity values (2, 8);
insert into posting_amenity values (2, 9);

insert into posting_amenity values (2, 6);
insert into posting_amenity values (2, 7);
insert into posting_amenity values (2, 10);
insert into posting_amenity values (3, 1);
insert into posting_amenity values (3, 6);
insert into posting_amenity values (3, 8);

drop table if exists posting_interest;
create table posting_interest (
        x POINT
);
