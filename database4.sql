DROP DATABASE ilers;
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* The relational tables of iLERS benchmark database				 */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

CREATE DATABASE ilers;

CREATE TABLE USERACC(
UA_USER_ID	                INT(12)	        NOT NULL AUTO_INCREMENT,
UA_FIRST_NAME	            VARCHAR(50)     NOT NULL,
UA_LAST_NAME	            VARCHAR(50)	    NOT NULL,
UA_EMAIL                    VARCHAR(255)    NOT NULL,
UA_TYPE	                    ENUM('Lecturer', 'SIM MGMT', 'Admin') NOT NULL,
UA_STATE                    VARCHAR (50)    NOT NULL,
UA_PASSWORD_HASH            VARCHAR(255)    NOT NULL,
UA_PASSWORD_RESET_HASH      VARCHAR(255)    DEFAULT NULL,
UA_PASSWORD_RESET_EXPIRY    DATETIME        DEFAULT NULL,
	CONSTRAINT USERACC_PKEY PRIMARY KEY(UA_USER_ID),
    CONSTRAINT USERACC_UNIQUE UNIQUE (UA_EMAIL)
);


INSERT INTO `USERACC` (`UA_USER_ID`, `UA_FIRST_NAME`, `UA_LAST_NAME`, `UA_EMAIL`, `UA_TYPE`,
`UA_STATE`, `UA_PASSWORD_HASH`, `UA_PASSWORD_RESET_HASH`, `UA_PASSWORD_RESET_EXPIRY`) VALUES
(1, 'Stuart', 'Daw', 'stuartdaw@gmail.com', 'lecturer', 'active', '$2y$10$WikuTzFV948Ks2MrCrSMe.fjkt5ReCe14yPvN/FR7w4yw8xSBk4wW', NULL, NULL),
(2, 'Dave', 'maz', 'stuartdaw@yahoo.com', 'lecturer', 'active', '$2y$10$WikuTzFV948Ks2MrCrSMe.fjkt5ReCe14yPvN/FR7w4yw8xSBk4wW', NULL, NULL),
(3, 'Eric', 'Blue', 'stuartdaw@prodoozy.com', 'SIM MGMT', 'active', '$2y$10$WikuTzFV948Ks2MrCrSMe.fjkt5ReCe14yPvN/FR7w4yw8xSBk4wW', NULL, NULL),
(4, 'Sun', 'tar', 'daw003@mymail.sim.edu', 'lecturer', 'active', '$2y$10$WikuTzFV948Ks2MrCrSMe.fjkt5ReCe14yPvN/FR7w4yw8xSBk4wW', NULL, NULL),
(5, 'Bernard', 'Lim', 'bernard3@mymail.sim.edu', 'SIM MGMT', 'active', '$2y$10$WikuTzFV948Ks2MrCrSMe.fjkt5ReCe14yPvN/FR7w4yw8xSBk4wW', NULL, NULL);

CREATE TABLE REMEMBER_LOGINS (
RL_TOKEN_HASH               VARCHAR(64)     NOT NULL,
RL_USER_ID                  INT(12)         NOT NULL,
RL_EXPIRES_AT               DATETIME        NOT NULL,
    CONSTRAINT REMEMBER_LOGINS_PKEY PRIMARY KEY(RL_USER_ID),
    CONSTRAINT RL_FK1_USER_ID FOREIGN KEY (RL_USER_ID) REFERENCES USERACC (UA_USER_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE QUALIFICATION(
Q_NUM	                    INT(12)	        NOT NULL AUTO_INCREMENT,
Q_SCHOOL	                VARCHAR(50)	    NOT NULL,
Q_MAJOR		                VARCHAR(50)	    NOT NULL,
Q_NAME                      VARCHAR(50)	    NOT NULL,
Q_LEVEL                     ENUM('Phd', 'Msc', 'Degree', 'Postgrad Certificate', 'Diploma', 'Other') NOT NULL,
Q_DESC                      VARCHAR(250),
Q_GRADYEAR      	        INT(4)	        NOT NULL,
Q_CLASSIFICATION	        VARCHAR(50)	    NOT NULL,
Q_DOCNAME	       	        VARCHAR(50),
Q_DOCTYPE	    	        VARCHAR(50),
Q_DOCPATH	                VARCHAR (50),
Q_USER_ID                   INT(12)	        NOT NULL,
	CONSTRAINT QUALIFICATION_PKEY PRIMARY KEY(Q_NUM),
	CONSTRAINT QUALIFICATION_FKEY1 FOREIGN KEY (Q_USER_ID)
		REFERENCES USERACC(UA_USER_ID)
);

INSERT INTO `QUALIFICATION` (`Q_NUM`, `Q_SCHOOL`, `Q_MAJOR`, `Q_NAME`, `Q_LEVEL`, `Q_DESC`, `Q_GRADYEAR`, `Q_CLASSIFICATION`,
                             `Q_DOCNAME`, `Q_DOCTYPE`, `Q_DOCPATH`, `Q_USER_ID`)
VALUES
(1,'Bath University', 'Business Administration', '', 'Degree', '', 2007, '2.1', NULL, NULL, NULL, 1),
(2, 'UOW', 'Computer Science', '', 'Degree', '', 2020, 'Pass', NULL, NULL, NULL, 1);

CREATE TABLE SKILLS(
S_NUM	                    INT(12)	        NOT NULL AUTO_INCREMENT,
S_NAME		                VARCHAR(50)	    NOT NULL,
S_PROFICIENCY		        VARCHAR(50)	    NOT NULL,
S_DESC		                VARCHAR(50)	    NOT NULL,
S_DOCNAME	    	        VARCHAR(50),
S_DOCTYPE	    	        VARCHAR(50),
S_DOCPATH	                VARCHAR(50),
S_USER_ID	                INT(12)	        NOT NULL,
	CONSTRAINT SKILLS_PKEY PRIMARY KEY(S_NUM),
	CONSTRAINT SKILLS_FK1_USER_ID FOREIGN KEY (S_USER_ID)
		REFERENCES USERACC(UA_USER_ID)
);
INSERT INTO `SKILLS` (`S_NUM`, `S_NAME`, `S_PROFICIENCY`, `S_DESC`, `S_DOCNAME`, `S_DOCTYPE`, `S_DOCPATH`, `S_USER_ID`)
VALUES (1,'Python', 'intermediate', '3 Years experience coding python', NULL, NULL, NULL, '1');

CREATE TABLE EXPERIENCE(
E_NUM	                    INT(12)	        NOT NULL AUTO_INCREMENT,
E_ORG   		            VARCHAR(50)	    NOT NULL,
E_POSITION		            VARCHAR(50)	    NOT NULL,
E_START                     DATE            NOT NULL,
E_YEARS			            INT(4)	        NOT NULL,
E_DESC	                    VARCHAR(255)	NOT NULL,
E_USER_ID	                INT(12)	        NOT NULL,
	CONSTRAINT EXPERIENCE_PKEY PRIMARY KEY(E_NUM),
	CONSTRAINT EXPERIENCE_FK1_USER_ID FOREIGN KEY (E_USER_ID)
		REFERENCES USERACC(UA_USER_ID)
);

INSERT INTO `EXPERIENCE` (`E_NUM`,`E_ORG`, `E_POSITION`, `E_START`, `E_YEARS`, `E_DESC`, `E_USER_ID`)
VALUES
(1, 'ConocoPhillips', 'Risk Analyst', '2007-12-05', '6', 'Var, Daily, PnL and Exposure reporting. Hedging programs', '1');

CREATE TABLE PROFILE(
PF_USER_ID	                INT(12)	        NOT NULL,
PF_DOB	        	        DATE            NOT NULL,
PF_ROAD                     VARCHAR(100)    NOT NULL,
PF_UNIT                     VARCHAR(100)    NOT NULL,
PF_COUNTRY                  VARCHAR(25)     NOT NULL,
PF_CODE                     VARCHAR(20)     NOT NULL,
PF_PHONE                    VARCHAR(50)	    NOT NULL,
PF_SEX                      ENUM('MALE', 'FEMALE', 'NB'),
PF_SESSION_DAY		        ENUM('AVAILABLE', 'UNAVAILABLE') NOT NULL,
PF_SESSION_EVENING	        ENUM('AVAILABLE', 'UNAVAILABLE') NOT NULL,
	CONSTRAINT PROFILE_PKEY PRIMARY KEY(PF_USER_ID),
	CONSTRAINT PROFILE_FK1_USER_ID FOREIGN KEY (PF_USER_ID)
		REFERENCES USERACC(UA_USER_ID)
);
INSERT INTO `PROFILE` (`PF_USER_ID`, `PF_DOB`, `PF_ROAD`, `PF_UNIT`, `PF_COUNTRY`, `PF_CODE`, `PF_PHONE`, `PF_SEX`, `PF_SESSION_DAY`, `PF_SESSION_EVENING`)
VALUES ('1', '2000-01-13', '20C Duchess Road', '#03-15 Duchess Manor', 'Singapore', '269033', '83896783', 'MALE', 'AVAILABLE', 'UNAVAILABLE');

CREATE TABLE POSITIONS(
P_NUM                       INT(12)         NOT NULL AUTO_INCREMENT,
P_REF                       VARCHAR(20)     NOT NULL,
P_TITLE                     VARCHAR(50)     NOT NULL,
P_UNIVERSITY                VARCHAR(50)     NOT NULL,
P_PROG                      VARCHAR(50)     NOT NULL,
P_DESC	                    VARCHAR(1500)	NOT NULL,
P_REQ	                    VARCHAR(1500)	NOT NULL,
P_PHD                       ENUM ('Required', 'Preferred', '-'),
P_MSC                       ENUM ('Required', 'Preferred', '-'),
P_DEGREE                    ENUM ('Required', 'Preferred', '-'),
P_TEACH_EXPERIENCE          INT(3),
P_IND_EXPERIENCE            INT(3),
P_STATUS                    ENUM ('Open', 'Filled', 'draft'),
P_SESSION                   ENUM ('DAY', 'EVENING', 'BOTH'),
P_ADDED_BY                  INT(12)	        NOT NULL,
    CONSTRAINT POSITIONS_PKEY PRIMARY KEY (P_NUM),
    CONSTRAINT POSITIONS._FK1_ADDED_BY FOREIGN KEY (P_ADDED_BY ) REFERENCES USERACC (UA_USER_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

INSERT INTO `POSITIONS` (`P_NUM`, `P_REF`, `P_TITLE`, `P_UNIVERSITY`, `P_PROG`, `P_DESC`, `P_REQ`, `P_PHD`, `P_MSC`, `P_DEGREE`, `P_TEACH_EXPERIENCE`, `P_IND_EXPERIENCE`, `P_STATUS`, `P_SESSION`, `P_ADDED_BY`) VALUES
(1, 'REF: W0419-HE1', 'Artificial Intelligence', 'UOW', 'Big Data', 'Aims: This module is focused on Artificial Intelligence techniques. You will understand the historical development of
Artificial Intelligence including search, vision and planning. You will be familiar with the foundations of agent-based approach to software design, decision making and problem solving
including under uncertainty. You will have an opportunity to apply Artificial Intelligence techniques.\r\n\r\nAssessment Elements\r\n1. 2 Coursework (30% weighting)\r\n2. 3-hours written
Examination (70% weighting) - comprise of three sections with a mix of qualitative and quantitative questions.', '- A Ph.D or Master\'s Degree in related discipline from a reputable
university.\r\n- At least 5 years of experience teaching maths, statistics, machine learning, artificial intelligence, financial technology, python, data mining and visualisation\r\n-
5 years of relevant work experience will be an added advantage\r\n- Applicant must be able to teach day time classes.', 'Preferred', 'Required', 'Required', 5, 5, 'Open', 'DAY', 3),
(2, 'REF: W0419-HE1', 'Big Data Analysis', 'UOW', 'Big Data', 'New module for  new programme - Big Data Analysis\r\n\r\nRationale: This module covers the topic of Big Data which is a
key element of contemporary applications of Data Science. It provides practical skills related to working with Big Data computing resources as well as the conceptual context of how Big
Data relates to methods and technologies in statistics and computing. The module is complementary to Machine Learning and other modules.\r\n\r\nAims: By taking this module, you will gain
an in-depth understanding of the technology and methods used for Big Data analysis and how they relate to concepts in statistics and computing more generally. The technologies will include
distributed filesystems, SQL and NoSQL databases, parallel computing and cluster computing. You will learn what the key challenges are in Big Data analysis, how they relate to privacy
and security and how these are addressed with current technologies. You will work in Python, a modern language widely used in Big Data analysis. You will use querying to extract data,
then design data processing and analysis pipelines to analyse the data. You will learn how to apply these techniques to data in business and scientific applications.\r\n\r\nAssessment
Elements\r\n1. 2 Coursework (30% weighting)\r\n2. 3-hours written Examination (70% weighting) - comprise of three sections with a mix of qualitative and quantitative questions.',
 '- A Ph.D or Master\'s Degree in related discipline from a reputable university.\r\n- At least 5 years of experience teaching maths, statistics, machine learning, artificial
intelligence, financial technology, python, data mining and visualisation\r\n- 5 years of relevant work experience will be an added advantage\r\n- Applicant must be able to teach day
time classes.', 'Preferred', 'Preferred', 'Required', 5, 5, 'Open','EVENING',5);


CREATE TABLE APPLICATION(
APC_USER_ID	INT(12)	NOT NULL,
APC_POSKEY	INT(12)	NOT NULL,
APC_DATEAPPLY	DATE	NOT NULL,
APC_STATUS		VARCHAR(12)	NOT NULL,
	CONSTRAINT APPLICATION_FKEY1 FOREIGN KEY (APC_USER_ID)
		REFERENCES PROFILE(PF_USER_ID),
	CONSTRAINT APPLICATION_FKEY2 FOREIGN KEY (APC_POSKEY)
		REFERENCES POSITIONS(P_NUM),
	CONSTRAINT APPLICATION_PKEY PRIMARY KEY(APC_USER_ID, APC_POSKEY)
);

CREATE TABLE INVITATION(
I_INKEY	INT(12)	NOT NULL,
I_FIRSTNAME	VARCHAR(50)	NOT NULL,
I_LASTNAME	VARCHAR(50)	NOT NULL,
I_EMAIL		VARCHAR(50)	NOT NULL,
I_POSITION	VARCHAR (50)	NOT NULL,
I_INVITEDATE	DATE	NOT NULL,
I_SENDBY	VARCHAR(50)	NOT NULL,
	CONSTRAINT INVITATION_PKEY PRIMARY KEY(I_INKEY)
);

CREATE TABLE INTERVIEW(
IV_INVKEY	INT(12)	NOT NULL,
IV_VENUE	VARCHAR(50)	NOT NULL,
IV_DATE_TIME		DATETIME NOT NULL,
IV_INTERVIEWER		VARCHAR(50)	NOT NULL,
IV_DECISION		VARCHAR(50)	NOT NULL,
	CONSTRAINT INTERVIEW_PKEY PRIMARY KEY(IV_INVKEY)
);

CREATE TABLE SIMMGMT(
SM_MKEY	INT(12)	NOT NULL,
SM_INKEY	INT(12)	NOT NULL,
SM_USER_ID	INT(12)	NOT NULL,
SM_INVKEY	INT(12)	NOT NULL,
SM_POSKEY	INT(12)	NOT NULL,
	CONSTRAINT SIMMGMT_PKEY PRIMARY KEY(SM_MKEY),
	CONSTRAINT SIMMGMT_FKEY1 FOREIGN KEY (SM_INKEY)
		REFERENCES INVITATION(I_INKEY),
	CONSTRAINT SIMMGMT_FKEY2 FOREIGN KEY (SM_USER_ID)
		REFERENCES PROFILE(PF_USER_ID),
	CONSTRAINT SIMMGMT_FKEY3 FOREIGN KEY (SM_INVKEY)
		REFERENCES INTERVIEW(IV_INVKEY),
	CONSTRAINT SIMMGMT_FKEY4 FOREIGN KEY (SM_POSKEY)
		REFERENCES POSITIONS(P_NUM)
);