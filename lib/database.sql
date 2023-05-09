create database EnglishCenter;

-- bảng học sinh 
create table HOCSINH(
     MaHS INTEGER PRIMARY KEY AUTO_INCREMENT,
     TENHS nvarchar(50) not null,
     GioiTinh varchar(20) not null,
     NgaySinh date not null,
     Tuoi INTEGER not null,
     DIACHI varchar(100) not null,
     sdt INTEGER not null, 
     Email varchar(50) not null
);

insert into HOCSINH(TENHS,GioiTinh,NgaySinh,Tuoi,DIACHI,sdt,Email) values
('Nguyen Van A', 'Nam', '2005-01-01', 18, 'Ha Noi', 123456789, 'nguyenvana@gmail.com'),
('Tran Thi B', 'Nu', '2006-02-02', 17, 'Ho Chi Minh', 987654321, 'tranthib@gmail.com');

create table TK_HS(
     TenDN varchar(40) primary key,
     MaHS INTEGER ,
     passWord varchar(50) not null
);

INSERT INTO TK_HS(TenDN, MaHS, passWord) VALUES
('user1', 1, '123'),
('user2', 2, '123');

ALTER TABLE TK_HS
ADD CONSTRAINT fk_hs
FOREIGN KEY (MaHS)
REFERENCES HOCSINH(MaHS);

-- bảng học sinh 








