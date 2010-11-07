DROP TABLE IF EXISTS postings;

CREATE TABLE postings (
`posting_id` BIGINT NOT NULL ,
`facebook_id` BIGINT NOT NULL,
`posting_address` VARCHAR( 4000 ) NULL ,
`posting_tags` VARCHAR( 4000 ) NULL ,
`page_id` VARCHAR( 4000 ) NULL ,
PRIMARY KEY ( `posting_id` )
) ENGINE = MYISAM
	
