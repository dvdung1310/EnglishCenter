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


-===========================================================================================

create database englishcenter

--admim

CREATE TABLE admin 
(UserName VARCHAR( 30) NOT NULL , 
Password VARCHAR(30) NOT NULL , 
PRIMARY KEY (UserName))


--hocsinh

CREATE TABLE hocsinh 
(MaHS INT NOT NULL AUTO_INCREMENT,
TenHS VARCHAR(30) NOT NULL , 
GioiTinh VARCHAR(5) NOT NULL , 
NgaySinh DATE NOT NULL , 
Tuoi INT NOT NULL , 
DiaChi VARCHAR(100) NOT NULL , 
SDT VARCHAR(11) NULL , 
Email VARCHAR(50) NULL , 
PRIMARY KEY (MaHS)) 

--tk_hs
CREATE TABLE tk_hs 
(UserName VARCHAR(30) NOT NULL , 
Password VARCHAR(30) NOT NULL , 
MaHS int not null,
foreign key (MaHS) references hocsinh(MaHS) , 
PRIMARY KEY (UserName)) 

--phuhuynh
CREATE TABLE phuhuynh 
(MaPH INT NOT NULL AUTO_INCREMENT,
TenPH VARCHAR(30) NOT NULL , 
GioiTinh VARCHAR(5) NOT NULL , 
NgaySinh DATE NOT NULL , 
Tuoi INT NOT NULL , 
DiaChi VARCHAR(100) NOT NULL , 
SDT VARCHAR(11) NULL , 
Email VARCHAR(50) NULL , 
PRIMARY KEY (MaPH)) 

--tk_ph
CREATE TABLE tk_ph 
(UserName VARCHAR(30) NOT NULL , 
Password VARCHAR(30) NOT NULL , 
MaPH int not null,
foreign key (MaPH) references phuhuynh(MaPH) , 
PRIMARY KEY (UserName))

--ph-hs
CREATE TABLE ph_hs
(MAHS int,
MaPH int,
foreign key (MaPH) references phuhuynh(MaPH) ,
foreign key (MaHS) references hocsinh(MaHS) ,
PRIMARY KEY (MaHS,MaPH)) 

--giaovien
CREATE TABLE giaovien 
(MaGV INT NOT NULL AUTO_INCREMENT,
TenGV VARCHAR(30) NOT NULL , 
GioiTinh VARCHAR(5) NOT NULL , 
NgaySinh DATE NOT NULL , 
Tuoi INT NOT NULL ,
QueQuan VARCHAR(100) NOT NULL ,
DiaChi VARCHAR(100) NOT NULL ,
TrinhDo VARCHAR(100) NOT NULL ,
SDT VARCHAR(11) NOT NULL , 
Email VARCHAR(50) NOT NULL , 
PRIMARY KEY (MaGV)) 

--tk_gv
CREATE TABLE tk_gv (
UserName VARCHAR(30) NOT NULL , 
Password VARCHAR(30) NOT NULL , 
MaGV int, 
foreign key (MaGV) references giaovien(MaGV) , 
PRIMARY KEY (UserName));

--lop
CREATE TABLE lop 
(MaLop varchar(20),
 TenLop VARCHAR(100) NOT NULL , 
 LuaTuoi int not null,
 ThoiGian date not null,
 SLHS int not null DEFAULT '0',
 SLHSToiDa int not null,
 HocPhi float not null,
 SoBuoi int not null,
 SoBuoiDaToChuc int not null,
 TrangThai varchar(200),
PRIMARY KEY (MaLop)) 

--gv_lop
CREATE TABLE gv_lop
(MAGV int,
MaLop varchar(20),
foreign key (MaGV) references giaovien(MaGV) ,
foreign key (MaLop) references lop(MaLop) ,
PRIMARY KEY (MaGV,MaLop)) 

--hs_lop
CREATE TABLE hs_lop 
(MAHS int, 
MaLop varchar(20),
SoBuoiNghi int DEFAULT '0', 
GiamHocPhi float DEFAULT '0', 
foreign key (MaHS) references hocsinh(MaHS) , 
foreign key (MaLop) references lop(MaLop) ,
PRIMARY KEY (MaHS,MaLop));

--diemdanh
CREATE TABLE diemdanh
(
MaLop varchar(20),
MAHS int, 
ThoiGian date not null,
dd boolean not null,
foreign key (MaHS) references hocsinh(MaHS) , 
foreign key (MaLop) references lop(MaLop) ,
PRIMARY KEY (MaHS,MaLop,ThoiGian));

--thuhocphi

CREATE TABLE thuhocphi 
(MaLop varchar(20) not null,
 MAHS int NOT null,
 ThoiGian date not null,
 SoTien float NOT null,
 GiamHocPhi float DEFAULT '0',
 SoTienGiam float DEFAULT '0',
 SoTienPhaiDong float not null,
 SoTienDaDong float not null,
 NoPhiConLai float not null,
 TrangThai varchar(50),
 NgayDong date ,
PRIMARY KEY (MaHS,MaLop,ThoiGian)) 


--lich_hoc
CREATE TABLE lich_hoc( MaLop VARCHAR(20),GioBatDau TIME, GioKetThuc TIME, Thu VARCHAR(10), PRIMARY KEY (MaLop, Thu, GioBatDau), FOREIGN KEY (MaLop) REFERENCES lop (MaLop) );











