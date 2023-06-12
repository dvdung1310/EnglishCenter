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
SDT VARCHAR(11) NOT NULL , 
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
(MaHS int,
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

--lich hoc
CREATE TABLE schedules (
    idSchedules INT PRIMARY KEY AUTO_INCREMENT,
    day_of_week VARCHAR(10) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
);

--lop_lichhoc
CREATE TABLE schedules_class
(idSchedules int,
MaLop varchar(20),
foreign key (idSchedules) references schedules(idSchedules) ,
foreign key (MaLop) references lop(MaLop) ,
PRIMARY KEY (idSchedules,MaLop)) 



--gv_lop
CREATE TABLE gv_lop
(MaGV int,
MaLop varchar(20),
foreign key (MaGV) references giaovien(MaGV) ,
foreign key (MaLop) references lop(MaLop) ,
PRIMARY KEY (MaGV,MaLop)) 

--hs_lop
CREATE TABLE hs_lop 
(MaHS int, 
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
MaHS int, 
ThoiGian date not null,
dd boolean not null,
foreign key (MaHS) references hocsinh(MaHS) , 
foreign key (MaLop) references lop(MaLop) ,
PRIMARY KEY (MaHS,MaLop,ThoiGian));

--HDHocPhi

CREATE TABLE hdhocphi
(
MaHD INT NOT NULL AUTO_INCREMENT,
TenHD VARCHAR(100) not null,
MaLop varchar(20) not null,
 MaHS int NOT null,
 ThoiGian varchar(50) not null,
 SoTien float NOT null,
 GiamHocPhi float DEFAULT '0',
 SoTienGiam float DEFAULT '0',
 SoTienPhaiDong float not null,
 SoTienDaDong float not null,
 NoPhiConLai float not null,
 TrangThai varchar(50),
 foreign key (MaHS) references hs_lop(MaHS) , 
foreign key (MaLop) references hs_lop(MaLop) ,
PRIMARY KEY (MaHD) )

---Lịch sử thu hoc phi

CREATE TABLE lsthp
(
MaGD int NOT NULL AUTO_INCREMENT,
MaHD INT  not null,
ThoiGian date not null,
SoTien float not null,
foreign key (MaHD) references HDHocPhi(MaHD) ,
PRIMARY KEY (MaGD) )

---Luong giao vien
CREATE TABLE `englishcenter`.`luonggv` 
(`MaLuong` INT NOT NULL , 
`MaGV` INT NOT NULL , 
`ThoiGian` VARCHAR(20) NOT NULL , 
`Lop` varchar(1000),
`ThoiGianTT` DATE NULL , 
`SoTien` INT NOT NULL , 
`TrangThai` INT NOT NULL , 
`Tên` VARCHAR(100) NOT NULL , 
PRIMARY KEY (`MaLuong`)) ENGINE = InnoDB;


-- chi phi khac

CREATE TABLE `englishcenter`.`chiphikhac` 
(`MaHD` INT AUTO_INCREMENT  , 
`TenHD` varchar(500) NOT NULL , 
`LoaiHD` VARCHAR(500) NOT NULL , 
`ThoiGian` varchar(50),
`ThoiGianTT` DATE NULL , 
`SoTien` INT NOT NULL , 
`TrangThai` INT NOT NULL , 
PRIMARY KEY (`MaHD`)) ENGINE = InnoDB;

--lopghp

CREATE TABLE `englishcenter`.`lopghp` 
(`MaLop` VARCHAR(20) NOT NULL , 
`TGBatDau` DATE NOT NULL , 
`TGKetThuc` DATE NOT NULL ,
 `GiamHocPhi` FLOAT NOT NULL ,
PRIMARY KEY (`MaLop`),
 foreign key (MaLop) references lop(Malop)) ENGINE = InnoDB;

 -- lienketph_hs
 CREATE TABLE `englishcenter`.`lopghp` 
(`MaHS` int NOT NULL , 
`MaPH` int NOT NULL , 
`TenHS` varchar(50) NOT NULL ,
 `TenPH` varchar(50) NOT NULL ,
 `nyc` varchar(10) not null,
PRIMARY KEY (`MaHS`,`MaPH`),
 foreign key (MaHS) references hocsinh(MaHS)
 foreign key (MaPH) references hocsinh(MaPH)) ENGINE = InnoDB;