CREATE TABLE IF NOT EXISTS `form_contacts` (
id bigint(20) NOT NULL auto_increment,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
od_base_curve longtext,
od_sphere longtext,
od_cylinder longtext,
od_axis longtext,
od_diameter longtext,
os_base_curve longtext,
os_sphere longtext,
os_cylinder longtext,
os_axis longtext,
os_diameter longtext,
material longtext,
color longtext,
bifocal_type longtext,
add_value longtext,
va_far longtext,
va_near longtext,
additional_notes longtext,
PRIMARY KEY (id)
) ENGINE=InnoDB;
