create database if not exists awesome;
use awesome;

drop table if exists rooms;
create table rooms (
  id char(32) not null primary key,
  top char(32),
  bottom char(32),
  `left` char(32),
  `right` char(32),
  title varchar(255)
) engine=InnoDB, charset=UTF8;


insert rooms VALUES (MD5('awesome room is awsome'), MD5('awesometop'), MD5('awesomeobt'), MD5('awesomel'), MD5('awesomer'), 'Awesome room');
