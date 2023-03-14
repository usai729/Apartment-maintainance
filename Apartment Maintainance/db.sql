CREATE DATABASE apartment_maintainance;

USE apartment_maintainance;

CREATE TABLE flats (
	flatid INTEGER PRIMARY KEY AUTO_INCREMENT,
    residing_block VARCHAR(10) NOT NULL,
    flat_num VARCHAR(10) NOT NULL,
    owner_name VARCHAR(100) NOT NULL,
    management BOOLEAN,
    tenents BOOLEAN,
    phone INTEGER NOT NULL,
    pwd TEXT NOT NULL
);
/*INSERT INTO flats(residing_block, flat_num, owner_name, management, tenents, phone, pwd) 
VALUES("C", "C001", "C001XYZ", false, false, 901287512, "C001XYZ"),("C", "C002", "C002XYZ", true, false, 908853514, "C002XYZ");*/
SELECT * FROM flats; /*901287512*/

CREATE TABLE maintenance (
	payment_id INT PRIMARY KEY AUTO_INCREMENT, 
    payment_by INT, 
    amount INT, 
    payment_date DATE,
    FOREIGN KEY(payment_by) REFERENCES flats(flatid)
);
SELECT * FROM apartment_maintainance.maintenance;
DESC maintenance;
ALTER TABLE maintenance ADD COLUMN paymentUniId TEXT AFTER payment_id;

CREATE TABLE tenents (
	tenentid INTEGER PRIMARY KEY AUTO_INCREMENT,
    ofFlat INTEGER,
    noOfPeopleInFlat INTEGER,
    FOREIGN KEY(ofFlat) REFERENCES flats(flatid) ON DELETE CASCADE
);

CREATE TABLE posts (
	postId INTEGER PRIMARY KEY AUTO_INCREMENT,
    postBy INTEGER NOT NULL,
    post TEXT NOT NULL,
    FOREIGN KEY(postBy) REFERENCES flats(flatid)
);
ALTER TABLE posts ADD COLUMN addedOn DATE AFTER post;
SELECT * FROM posts;
DELETE FROM posts WHERE postId=1;
ALTER TABLE posts ADD COLUMN agree_count INTEGER DEFAULT 0 AFTER post;
ALTER TABLE posts ADD COLUMN disagree_count INTEGER DEFAULT 0 AFTER agree_count;

CREATE TABLE replies (
	replyId INTEGER PRIMARY KEY AUTO_INCREMENT,
    replyTo INTEGER,
    replyBy INTEGER,
    reply TEXT,
    FOREIGN KEY(replyTo) REFERENCES posts(postId) ON DELETE CASCADE,
    FOREIGN KEY(replyBy) REFERENCES flats(flatid) ON DELETE CASCADE
);
INSERT INTO replies(replyTo, replyBy, reply) VALUES(3, 2, "Reply 2");
