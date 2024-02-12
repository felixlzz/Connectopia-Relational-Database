BEGIN

EXECUTE IMMEDIATE 'drop table appuser cascade constraints';
EXECUTE IMMEDIATE 'drop table Bot cascade constraints';
EXECUTE IMMEDIATE 'drop table Event cascade constraints';
EXECUTE IMMEDIATE 'drop table RSVP cascade constraints';
EXECUTE IMMEDIATE 'drop table Feed cascade constraints';
EXECUTE IMMEDIATE 'drop table Post cascade constraints';
EXECUTE IMMEDIATE 'drop table PostComment cascade constraints';
EXECUTE IMMEDIATE 'drop table Chat cascade constraints';
EXECUTE IMMEDIATE 'drop table Message cascade constraints';
EXECUTE IMMEDIATE 'drop table PGroup cascade constraints';
EXECUTE IMMEDIATE 'drop table Permission cascade constraints';
EXECUTE IMMEDIATE 'drop table HasPermission cascade constraints';
EXECUTE IMMEDIATE 'drop table UserBelongs cascade constraints';

EXECUTE IMMEDIATE 'CREATE TABLE appuser
	(username	CHAR(20) PRIMARY KEY,
	 joindate	TIMESTAMP NOT NULL,
	 icon		VARCHAR(32),
	 bio		VARCHAR(4000),
	 banned		CHAR(1) NOT NULL)';

EXECUTE IMMEDIATE 'CREATE TABLE Bot
	(username	CHAR(20) PRIMARY KEY,
	 token 	    CHAR(36) NOT NULL,
	 url		VARCHAR(4000),
	 FOREIGN KEY (username) REFERENCES appuser ON DELETE CASCADE)';

EXECUTE IMMEDIATE 'CREATE TABLE Event
	(location	VARCHAR(4000),
	 eday		TIMESTAMP,
	 name		CHAR(20),
	 username	CHAR(20),
	 PRIMARY KEY (location, eday),
	 FOREIGN KEY (username) REFERENCES appuser)';

EXECUTE IMMEDIATE 'CREATE TABLE RSVP
	(location	VARCHAR(4000),
	 eday		TIMESTAMP,
	 username	CHAR(20),
	 PRIMARY KEY (location, eday, username),
	 FOREIGN KEY (location, eday) REFERENCES Event ON DELETE CASCADE,
	 FOREIGN KEY (username) REFERENCES appuser ON DELETE CASCADE)';

EXECUTE IMMEDIATE 'CREATE TABLE Feed
	(title		CHAR(20) PRIMARY KEY,
	 icon		VARCHAR(32),
	 description	VARCHAR(4000))';

EXECUTE IMMEDIATE 'CREATE TABLE Post
	(pid		INTEGER,
	 title		VARCHAR(4000),
	 ptype 		CHAR(3) NOT NULL,
	 pdesc		VARCHAR(4000),
	 pdate		TIMESTAMP NOT NULL,
	 score		INTEGER NOT NULL,
	 username	CHAR(20),
	 ftitle		CHAR(20),
	 PRIMARY KEY (pid),
	 FOREIGN KEY (username) REFERENCES appuser ON DELETE CASCADE,
	 FOREIGN KEY (ftitle) REFERENCES Feed (title) ON DELETE CASCADE)';

EXECUTE IMMEDIATE 'CREATE TABLE PostComment
	(cmid		INTEGER,
	 text		VARCHAR(4000) NOT NULL,
	 cdate		TIMESTAMP NOT NULL,
	 score		INTEGER NOT NULL,
	 pid		INTEGER,
	 username	CHAR(20),
	 PRIMARY KEY (cmid, pid),
	 FOREIGN KEY (pid) REFERENCES Post ON DELETE CASCADE,
	 FOREIGN KEY (username) REFERENCES appuser ON DELETE CASCADE)';

EXECUTE IMMEDIATE 'CREATE TABLE Chat
	(cid		INTEGER PRIMARY KEY,
	 icon		VARCHAR(32),
	 name		VARCHAR(4000))';

EXECUTE IMMEDIATE 'CREATE TABLE Message
	(msgid		INTEGER primary key,
	 text     	VARCHAR(4000) NOT NULL,
	 mdate		TIMESTAMP NOT NULL,
	 cid		INTEGER,
	 username 	CHAR(20),
	 FOREIGN KEY (cid) REFERENCES Chat ON DELETE CASCADE,
	 FOREIGN KEY (username) REFERENCES appuser ON DELETE CASCADE)';

EXECUTE IMMEDIATE 'CREATE TABLE PGroup
	(name		    CHAR(20) PRIMARY KEY,
	 displayname	CHAR(20),
	 icon		    VARCHAR(32))';

EXECUTE IMMEDIATE 'CREATE TABLE Permission
	(node		VARCHAR(4000) PRIMARY KEY)';

EXECUTE IMMEDIATE 'CREATE TABLE HasPermission 
	(name		CHAR(20),
	 node		VARCHAR(4000),
	 pvalue		CHAR(1),
	 PRIMARY KEY (name, node),
	 FOREIGN KEY (name) REFERENCES PGroup ON DELETE CASCADE,
	 FOREIGN KEY (node) REFERENCES Permission ON DELETE CASCADE)';

EXECUTE IMMEDIATE 'CREATE TABLE UserBelongs 
	(username	CHAR(20),
	 name		CHAR(20),
	 PRIMARY KEY (username, name),
	 FOREIGN KEY (username) REFERENCES appuser ON DELETE CASCADE,
	 FOREIGN KEY (name) REFERENCES PGroup ON DELETE CASCADE)';
	 
	 
INSERT ALL
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('john_doe', TO_DATE('2022-04-15 8:30:45', 'yyyy/mm/dd hh24:mi:ss'), 'ac1451', 'Tech enthusiast', 0)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('susan_ss', TO_DATE('2023-01-20 14:15:20', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', 'Photography lover', 0)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('mike123', TO_DATE('2022-08-10 16:45:02', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', 'Gamer', 1)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('emily_blu', TO_DATE('2023-03-05 10:20:30', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', 'Foodie and traveler', 0)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('alex_garc', TO_DATE('2022-06-30 20:05:12', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', 'Music producer', 0)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('m310n', TO_DATE('2003-05-15 20:05:12', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', 'Gamer', 0)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('beep1', TO_DATE('2022-01-01 14:00:00', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', 'Beep boop', 0)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('boop2', TO_DATE('2022-01-02 14:00:00', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', 'Beep beep', 0)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('plup3', TO_DATE('2022-01-01 14:00:00', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', 'Beep', 0)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('boik4', TO_DATE('2023-01-01 12:00:30', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', '...', 0)
	INTO appuser(username, joindate, icon, bio, banned) VALUES ('ploopbot', TO_DATE('2023-01-09 16:30:00', 'yyyy/mm/dd hh24:mi:ss'), '6fabc7', 'zzzz', 0)
	
	INTO Bot (username, token, url) VALUES ('beep1', 'a1b2c3', 'https://beep1.com')
	INTO Bot (username, token, url) VALUES ('boop2', 'x4y5z6', 'https://boop2.com')
	INTO Bot (username, token, url) VALUES ('plup3', 'p7q8r9', 'https://plup3.com')
	INTO Bot (username, token, url) VALUES ('boik4', 'm1n2o3', 'https://boik4.com')
	INTO Bot (username, token, url) VALUES ('ploopbot', 't4u5v6', 'https://ploopbot.com')
	
	INTO Event (location, eday, name, username) VALUES ('San Francisco', TO_DATE('2023-09-20 10:00:00', 'yyyy/mm/dd hh24:mi:ss'), 'Hackathon', 'mike123')
	INTO Event (location, eday, name, username) VALUES ('Tokyo', TO_DATE('2023-10-30 20:30:00', 'yyyy/mm/dd hh24:mi:ss'), 'Music Festival', 'alex_garc')
	INTO Event (location, eday, name, username) VALUES ('Boston', TO_DATE('2013-08-13 12:30:00', 'yyyy/mm/dd hh24:mi:ss'), 'Flea Market', 'mike123')
	INTO Event (location, eday, name, username) VALUES ('Cambridge', TO_DATE('2021-05-18 09:00:00', 'yyyy/mm/dd hh24:mi:ss'), 'Sporting Event', 'emily_blu')
	INTO Event (location, eday, name, username) VALUES ('NYC', TO_DATE('2022-07-25 11:30:00', 'yyyy/mm/dd hh24:mi:ss'), 'Recycle Day', 'plup3')
	
	INTO RSVP(location, eday, username) VALUES ('San Francisco', TO_DATE('2023-09-20 10:00:00', 'yyyy/mm/dd hh24:mi:ss'), 'john_doe')
	INTO RSVP(location, eday, username) VALUES ('San Francisco', TO_DATE('2023-09-20 10:00:00', 'yyyy/mm/dd hh24:mi:ss'), 'mike123')
	INTO RSVP(location, eday, username) VALUES ('Tokyo', TO_DATE('2023-10-30 20:30:00', 'yyyy/mm/dd hh24:mi:ss'), 'beep1')
	INTO RSVP(location, eday, username) VALUES ('Tokyo', TO_DATE('2023-10-30 20:30:00', 'yyyy/mm/dd hh24:mi:ss'), 'emily_blu')
	
	INTO Feed (title, icon, description) VALUES ('Blogs', '19cab4', 'Read now!')
	INTO Feed (title, icon, description) VALUES ('Pics', '19cab4', 'Explore the world.')
	INTO Feed (title, icon, description) VALUES ('Tech', '19cab4', 'Latest tech news.')
	INTO Feed (title, icon, description) VALUES ('Food', '19cab4', 'Taste the delight.')
	INTO Feed (title, icon, description) VALUES ('Fitness', '19cab4', 'On the grind!')
	INTO Feed (title, icon, description) VALUES ('Misc', '19cab4', 'Random stuff.')
	
SELECT * FROM DUAL;

INSERT ALL
	
	INTO Post (pid,title,ptype,pdesc,pdate,score,username,ftitle) VALUES (1, 'Tips for Writings', 'TXT', 'A high-school teacher summary', TO_DATE('2013-12-5 8:16:09', 'yyyy/mm/dd hh24:mi:ss'), 144, 'john_doe', 'Blogs')
	INTO Post (pid,title,ptype,pdesc,pdate,score,username,ftitle) VALUES (2, 'AITA?', 'TXT', 'My girlfriend left me on read so I broke up. AITA?', TO_DATE('2014-12-5 2:10:09', 'yyyy/mm/dd hh24:mi:ss'), 225, 'mike123', 'Blogs')
	INTO Post (pid,title,ptype,pdesc,pdate,score,username,ftitle) VALUES (3, 'How to say hello', 'TXT', 'Social Book Chapter', TO_DATE('2020-8-25 12:01:00', 'yyyy/mm/dd hh24:mi:ss'), 352, 'emily_blu', 'Blogs')
	INTO Post (pid,title,ptype,pdesc,pdate,score,username,ftitle) VALUES (4, 'Gossip!', 'TXT', 'Whale Schools secret classroom', TO_DATE('2021-6-14 14:13:34', 'yyyy/mm/dd hh24:mi:ss'), 688, 'm310n', 'Misc')
	INTO Post (pid,title,ptype,pdesc,pdate,score,username,ftitle) VALUES (5, 'Worst UBC restaurant', 'TXT', 'Mercante pastas kinda suck tbh', TO_DATE('2023-1-15 19:13:00', 'yyyy/mm/dd hh24:mi:ss'), 233, 'm310n', 'Food')
	
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (1, 'Automod: Post approved', TO_DATE('2013-12-5 8:16:09', 'yyyy/mm/dd hh24:mi:ss'), 30, 1, 'ploopbot')
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (1, 'Automod: Post approved', TO_DATE('2014-12-5 2:10:09', 'yyyy/mm/dd hh24:mi:ss'), 25, 2, 'ploopbot')
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (1, 'Automod: Post approved', TO_DATE('2020-8-25 12:01:00', 'yyyy/mm/dd hh24:mi:ss'), 43, 3, 'ploopbot')
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (1, 'Automod: Post approved', TO_DATE('2021-6-14 14:13:34', 'yyyy/mm/dd hh24:mi:ss'), 74, 4, 'ploopbot')
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (1, 'Automod: Post approved', TO_DATE('2023-1-15 19:13:00', 'yyyy/mm/dd hh24:mi:ss'), 29, 5, 'ploopbot')
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (2, 'Nice pic', TO_DATE('2008-1-11 13:45:00', 'yyyy/mm/dd hh24:mi:ss'), 39, 4, 'beep1')
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (2, 'NTA', TO_DATE('2015-7-11 6:30:00', 'yyyy/mm/dd hh24:mi:ss'), 47, 2, 'susan_ss')
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (2, 'Thanks a lot', TO_DATE('2013-6-15 14:30:00', 'yyyy/mm/dd hh24:mi:ss'), 56, 3, 'mike123')
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (3, 'Great content sir', TO_DATE('2014-2-15 15:34:00', 'yyyy/mm/dd hh24:mi:ss'), 98, 4, 'mike123')
	INTO PostComment (cmid,text,cdate,score,pid,username) VALUES (4, 'Good luck', TO_DATE('2010-9-8 17:20:00', 'yyyy/mm/dd hh24:mi:ss'), 23, 4, 'susan_ss')
	
	INTO Chat (cid, icon, name) VALUES (1, '1aab27', 'Group Chat A')
	INTO Chat (cid, icon, name) VALUES (2, '1aab27', 'Friends Chat')
	INTO Chat (cid, icon, name) VALUES (3, '1aab27', 'Work Chat')
	INTO Chat (cid, icon, name) VALUES (4, '2aab27', 'Family Chat')
	INTO Chat (cid, icon, name) VALUES (5, '3aab27', 'Study Group')
	
	INTO Message (msgid,text,mdate,cid,username) VALUES (6329, 'hi', TO_DATE('2013-12-5 8:16:09', 'yyyy/mm/dd hh24:mi:ss'), 1, 'm310n')
   	INTO Message (msgid,text,mdate,cid,username) VALUES (28, 'Ill be late', TO_DATE('2020-8-25 12:01:00', 'yyyy/mm/dd hh24:mi:ss'), 2, 'john_doe')
	INTO Message (msgid,text,mdate,cid,username) VALUES (1329, 'what time?', TO_DATE('2021-6-14 14:13:34', 'yyyy/mm/dd hh24:mi:ss'), 3, 'emily_blu')
	INTO Message (msgid,text,mdate,cid,username) VALUES (36726, 'sorry', TO_DATE('2022-3-15 8:23:07', 'yyyy/mm/dd hh24:mi:ss'), 4, 'alex_garc')
	INTO Message (msgid,text,mdate,cid,username) VALUES (479, 'let me cc', TO_DATE('2023-2-16 13:05:16', 'yyyy/mm/dd hh24:mi:ss'), 3, 'mike123')
	
	INTO PGroup (name, displayname, icon) VALUES ('admin', 'Administrators', 'a')
	INTO PGroup (name, displayname, icon) VALUES ('mod', 'Moderators', 'b')
	INTO PGroup (name, displayname, icon) VALUES ('vip', 'VIP Members', 'c')
	INTO PGroup (name, displayname, icon) VALUES ('member', 'Registered Member', 'd')
	
	INTO Permission (node) VALUES ('chat.mute')
	INTO Permission (node) VALUES ('post.delete')
	INTO Permission (node) VALUES ('feed.view')
	INTO Permission (node) VALUES ('message.send')
	INTO Permission (node) VALUES ('user.ban')
	INTO Permission (node) VALUES ('message.like')
	
	INTO HasPermission (name, node, pvalue) VALUES ('member', 'user.ban', 0)
	INTO HasPermission (name, node, pvalue) VALUES ('member', 'feed.view', 1)
	INTO HasPermission (name, node, pvalue) VALUES ('mod', 'post.delete', 1)
	INTO HasPermission (name, node, pvalue) VALUES ('mod', 'user.ban', 1)
	INTO HasPermission (name, node, pvalue) VALUES ('admin', 'chat.mute', 1)
	
	INTO UserBelongs (username, name) VALUES ('john_doe', 'member')
	INTO UserBelongs (username, name) VALUES ('susan_ss', 'vip')
	INTO UserBelongs (username, name) VALUES ('mike123', 'member')
	INTO UserBelongs (username, name) VALUES ('emily_blu', 'member')
	INTO UserBelongs (username, name) VALUES ('alex_garc', 'vip')
	INTO UserBelongs (username, name) VALUES ('m310n', 'mod')
	INTO UserBelongs (username, name) VALUES ('beep1', 'mod')
	INTO UserBelongs (username, name) VALUES ('boop2', 'member')
	INTO UserBelongs (username, name) VALUES ('plup3', 'member')
	INTO UserBelongs (username, name) VALUES ('boik4', 'member')
	INTO UserBelongs (username, name) VALUES ('ploopbot', 'admin')

SELECT * FROM DUAL;

END;