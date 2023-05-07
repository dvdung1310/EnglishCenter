create table User(
     id INTEGER primary key AUTO_INCREMENT,
     userName varchar(30) not null ,
     passWord varchar(50) not null, 
     name varchar(40) not null,
     age INTEGER not null,
     phone varchar(11) not null 
);

insert into User(userName,passWord,name,age,phone) values
('startLiNH','123','Đặng lINH',20,'0336961703'),
('dung','123','Văn Dũng',18,'0336961705')


