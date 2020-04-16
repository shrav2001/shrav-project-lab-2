CREATE TABLE signupusers (
  usn int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  confirm_password varchar(100) NOT NULL,
phone int(100) NOT NULL,
) ENGINE=InnoDB;