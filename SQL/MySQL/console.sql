select OFFICIALNUMBER, m.SailorID, count(m.SailorID)
from medaltran m
       LEFT JOIN sailor s on s.SAILORID = m.SailorID
where s.SAILORSTATUS = 1
group by m.SailorID
order by 3 desc;


SELECT s.SAILORID,
       s.FULLNAME,
       TRIM(leading 0 FROM s.OFFICIALNUMBER)                                                         OFFICIALNUMBER,
       pu.NAME                                                                                       POST_UNIT,
       (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME
FROM sailor s
       LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
       LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
       LEFT JOIN bn_posting_unit pu on pu.POSTING_UNITID = s.POSTINGUNITID
WHERE s.SAILORID = '5557';

SELECT GROUP_CONCAT(TRIM(leading 0 FROM s.OFFICIALNUMBER)) OFFICIALNUMBER
FROM medaltran m
       LEFT JOIN sailor s ON m.SailorID = s.SAILORID
WHERE m.MedalID = '5'
  AND m.SailorID IN (15010, 10556, 5449);

SELECT h.MedalTranID,
       h.AuthorityNumber,
       h.AuthorityName,
       h.ShipID,
       h.AwardDate,
       h.AuthorityDate,
       h.DAOID,
       h.MedalID,
       pu.NAME                               POST_UNIT,
       TRIM(leading 0 FROM s.OFFICIALNUMBER) OFFICIALNUMBER,
       s.SAILORID,
       s.FULLNAME,
       r.RANK_NAME,
       bh.NAME                               MEDAL_NAME,
       se.AREA_ID,
       se.NAME                               SHIP_EST
FROM medaltran h
       LEFT JOIN sailor s on s.SAILORID = h.SailorID
       LEFT JOIN bn_rank r on r.RANK_ID = s.RANKID
       LEFT JOIN bn_medal bh on bh.MEDAL_ID = h.MedalID
       LEFT JOIN bn_ship_establishment se on se.SHIP_ESTABLISHMENTID = h.ShipID

       LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
       LEFT JOIN bn_posting_unit pu on pu.POSTING_UNITID = s.POSTINGUNITID
WHERE h.MedalTranID = '3069';

SELECT mt.MedalTranID,
       bm.NAME                                   Medals,
       DATE_FORMAT(mt.AwardDate, '%d-%m-%Y')     AwardDate,
       se.SHORT_NAME                             AuthorityShip,
       mt.AuthorityName,
       mt.AuthorityNumber,
       DATE_FORMAT(mt.AuthorityDate, '%d-%m-%Y') AuthorityDate,
       d.DAO_NO,
       cu.FULL_NAME                              EntryUser,
       DATE_FORMAT(mt.CRE_DT, '%d-%m-%Y')        EntryDate,
       uu.FULL_NAME                              UpdateUser,
       DATE_FORMAT(mt.UPD_DT, '%d-%m-%Y')        UpdateDate
from medaltran mt
       left join bn_medal bm on bm.MEDAL_ID = mt.MedalID
       left join bn_ship_establishment se on se.SHIP_ESTABLISHMENTID = mt.ShipID
       left join bn_dao d on d.DAO_ID = mt.DAOID
       left join sa_users cu on cu.USER_ID = mt.CRE_BY
       left join sa_users uu on uu.USER_ID = mt.UPD_BY
where mt.SailorID = '5557';

select *
from sailor
where SAILORID = 4339;
select *
from honortran
where SailorID = 4339;

select *
from medaltran
where SailorID = 22984
  and MedalID = 6
  and MedalTranID != 3075;

SELECT s.SAILORID,
       s.FULLNAME,
       TRIM(leading 0 FROM s.OFFICIALNUMBER)                                                         OFFICIALNUMBER,
       pu.NAME                                                                                       POSTNAME,
       (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME
FROM sailor s
       LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
       LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
       LEFT JOIN bn_posting_unit pu on pu.POSTING_UNITID = s.POSTINGUNITID
WHERE s.SAILORID = '5557';


SELECT h.*, TRIM(leading 0 FROM s.OFFICIALNUMBER) OFFICIALNUMBER, s.FULLNAME, r.RANK_NAME, bh.NAME HONOR_NAME,se.AREA_ID, se.NAME SHIP_EST
FROM honortran h
       INNER JOIN sailor s on s.SAILORID = h.SailorID
       INNER JOIN bn_rank r on r.RANK_ID = s.RANKID
       INNER JOIN bn_honor bh on bh.HONOR_ID = h.HonorID
       LEFT JOIN bn_ship_establishment se on se.SHIP_ESTABLISHMENTID = h.ShipID
WHERE h.HonorTranID = '';

SELECT h.HonorTranID,
       h.AuthorityNumber,
       h.AuthorityName,
       h.ShipID,
       date_format(h.AwardDate, '%d-%m-%Y')     AwardDate,
       date_format(h.AuthorityDate, '%d-%m-%Y') AuthorityDate,
       h.DAOID,
       h.HonorID,
       TRIM(leading 0 FROM s.OFFICIALNUMBER)    OFFICIALNUMBER,
       s.SAILORID,
       s.FULLNAME,
       r.RANK_NAME,
       bh.NAME                                  MEDAL_NAME,
       se.AREA_ID,
       se.NAME                                  SHIP_EST,
       pu.NAME                                  POSTNAME
FROM honortran h
       LEFT JOIN sailor s on s.SAILORID = h.SailorID
       LEFT JOIN bn_rank r on r.RANK_ID = s.RANKID
       LEFT JOIN bn_medal bh on bh.MEDAL_ID = h.HonorID
       LEFT JOIN bn_ship_establishment se on se.SHIP_ESTABLISHMENTID = h.ShipID
       LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
       LEFT JOIN bn_posting_unit pu on pu.POSTING_UNITID = s.POSTINGUNITID
WHERE h.HonorTranID = '343';

select *
from bn_dao
order by date desc;
select *
from bn_medal
order by CODE asc;


SELECT s.SAILORID,
       s.FULLNAME,
       date_format(s.ENTRYDATE, '%d-%m-%Y')                                                          ENTRYDATE,
       date_format(s.BIRTHDATE, '%d-%m-%Y')                                                          BIRTHDATE,
       date_format(s.PROMOTIONDATE, '%d-%m-%Y')                                                      PROMOTIONDATE,
       date_format(s.MARRIAGEDATE, '%d-%m-%Y')                                                       MARRIAGEDATE,
       s.NOOFCHILDREN,
       r.RANK_ID,
       (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME,
       sh.SHORT_NAME                                                                                 SHIP_ESTABLISHMENT,
       pu.NAME                                                                                       POSTING_UNIT_NAME,
       DATE_FORMAT(s.POSTINGDATE, '%d-%m-%Y')                                                        POSTING_DATE,
       mc.MedicalCategoryName
FROM sailor as s
       LEFT JOIN bn_posting_unit as pu ON pu.POSTING_UNITID = s.POSTINGUNITID
       LEFT JOIN partii as p ON s.FIRSTPARTID = p.PartIIID
       LEFT JOIN bn_ship_establishment as sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
       LEFT JOIN bn_rank as r ON r.RANK_ID = s.RANKID
       LEFT JOIN medicalcategory as mc ON mc.MedicalCategoryID = s.MEDICALCATEGORY
WHERE s.SAILORSTATUS = 1
  AND s.OFFICIALNUMBER = '00890134';

select *
from bn_roster;

select MARITALSTATUS, OFFICIALNUMBER, SAILORSTATUS,ACTIVE_STATUS
from sailor
where SAILORSTATUS = 1;

SELECT r.BNRosterID,
       r.AppliedShipID,
       s.SAILORID,
       s.FULLNAME,
       TRIM(leading 0 FROM s.OFFICIALNUMBER)    OFFICIALNUMBER,
       p.NAME                                   PostingUnit,
       rk.RANK_NAME,
       DATE_FORMAT(s.POSTINGDATE, '%d-%m-%Y')   POSTINGDATE,
       DATE_FORMAT(s.ENTRYDATE, '%d-%m-%Y')     Joiningdate,
       DATE_FORMAT(s.BIRTHDATE, '%d-%m-%Y')     BIRTHDATE,
       DATE_FORMAT(s.PROMOTIONDATE, '%d-%m-%Y') PROMOTIONDATE,
       DATE_FORMAT(r.MARRIAGEDATE, '%d-%m-%Y')  MARRIAGEDATE,
       sh.NAME                                  Applyship,
       DATE_FORMAT(r.ApplyDate, '%d-%m-%Y')     ApplyDate,
       s.NOOFCHILDREN
from bn_roster r
       left join sailor s on s.SAILORID = r.SailorID
       left join bn_posting_unit p on p.POSTING_UNITID = s.POSTINGUNITID
       left join bn_rank rk on rk.RANK_ID = s.RANKID
       left join bn_ship_establishment sh on sh.SHIP_ESTABLISHMENTID = r.AppliedShipID
where r.BNRosterID = '11750';

SELECT r.AppliedShipID,
       DATE_FORMAT(r.MarriageDate, '%d-%m-%Y')  MarriageDate,
       DATE_FORMAT(r.ApplyDate, '%d-%m-%Y')     ApplyDate,
       TRIM(leading 0 FROM s.OFFICIALNUMBER)    OFFICIALNUMBER,
       s.FULLNAME,
       rk.RANK_NAME,
       s.NOOFCHILDREN,
       se.NAME                                  SHIP_EST,
       DATE_FORMAT(s.PROMOTIONDATE, '%d-%m-%Y') PROMOTIONDATE,
       DATE_FORMAT(s.ENTRYDATE, '%d-%m-%Y')     ENTRYDATE,
       DATE_FORMAT(s.BIRTHDATE, '%d-%m-%Y')     BIRTHDATE,
       cu.FULL_NAME                             CRE_BY,
       DATE_FORMAT(r.CRE_DT, '%d-%m-%Y')        CRE_DT,
       uu.FULL_NAME                             UPD_BY,
       DATE_FORMAT(r.UPD_DT, '%d-%m-%Y')        UPD_DT
FROM bn_roster r
       LEFT JOIN sailor s on s.SAILORID = r.SailorID
       LEFT JOIN bn_rank rk on rk.RANK_ID = s.RANKID
       LEFT JOIN bn_ship_establishment se on r.AppliedShipID = se.SHIP_ESTABLISHMENTID
       LEFT JOIN sa_users cu ON cu.USER_ID = r.CRE_BY
       LEFT JOIN sa_users uu ON uu.USER_ID = r.UPD_BY;

SELECT ww.WillingNotWillingID,
       TRIM(leading 0 FROM s.OFFICIALNUMBER) OFFICIALNUMBER,
       s.FULLNAME,
       r.RANK_NAME,
       sh.NAME                               Ship,
       m.NAME                                Mission,
       cu.FULL_NAME                          CRE_BY,
       DATE_FORMAT(ww.CRE_DT, '%d-%m-%Y')    CRE_DT,
       uu.FULL_NAME                          UPD_BY,
       DATE_FORMAT(ww.UPD_DT, '%d-%m-%Y')    UPD_DT
from willingnotwilling ww
       LEFT join sailor s on s.SAILORID = ww.SailorID
       LEFT join bn_rank r on r.RANK_ID = s.RANKID
       LEFT join bn_ship_establishment sh on sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
       LEFT join bn_mission m on m.MISSION_ID = ww.MissionID
       LEFT JOIN sa_users cu ON cu.USER_ID = ww.CRE_BY
       LEFT JOIN sa_users uu ON uu.USER_ID = ww.UPD_BY
where ww.SailorID = '5557';

select MissionID, Opinion,SailorID
from willingnotwilling
where SailorID = 5557
  and MissionID = '1';

SELECT ww.WillingNotWillingID,
       TRIM(leading 0 FROM s.OFFICIALNUMBER) OFFICIALNUMBER,
       s.SAILORID,
       s.FULLNAME,
       r.RANK_NAME,
       sh.NAME                               Ship,
       m.NAME                                Mission,
       m.MISSION_ID,
       cu.FULL_NAME                          CRE_BY,
       DATE_FORMAT(ww.CRE_DT, '%d-%m-%Y')    CRE_DT,
       uu.FULL_NAME                          UPD_BY,
       DATE_FORMAT(ww.UPD_DT, '%d-%m-%Y')    UPD_DT
from willingnotwilling ww
       LEFT join sailor s on s.SAILORID = ww.SailorID
       LEFT join bn_rank r on r.RANK_ID = s.RANKID
       LEFT join bn_ship_establishment sh on sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
       LEFT join bn_mission m on m.MISSION_ID = ww.MissionID
       LEFT JOIN sa_users cu ON cu.USER_ID = ww.CRE_BY
       LEFT JOIN sa_users uu ON uu.USER_ID = ww.UPD_BY
where ww.WillingNotWillingID = '2660';

SELECT s.SAILORID,
       s.FULLNAME,
       TRIM(leading 0 FROM s.OFFICIALNUMBER)                                                         OFFICIALNUMBER,
       pu.NAME                                                                                       POSTNAME,
       (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME,
       sh.SHORT_NAME                                                                                 SHIP_ESTABLISHMENT
FROM sailor s
       LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
       LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
       LEFT JOIN bn_posting_unit pu on pu.POSTING_UNITID = s.POSTINGUNITID
       LEFT JOIN bn_ship_establishment sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
WHERE s.SAILORID = '5557';

SELECT s.SAILORID,
       s.FULLNAME,
       TRIM(leading 0 FROM s.OFFICIALNUMBER)                                                         OFFICIALNUMBER,
       pu.NAME                                                                                       POSTNAME,
       (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME,
       sh.SHORT_NAME                                                                                 SHIP_ESTABLISHMENT
FROM sailor s
       LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
       LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
       LEFT JOIN bn_posting_unit pu on pu.POSTING_UNITID = s.POSTINGUNITID
       LEFT JOIN bn_ship_establishment sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
WHERE s.SAILORID = '5557';

select *
from willingnotwilling
where SailorID = '5557'
  and WillingNotWillingID != '11593'
  and MissionID = '3';

select JesthataPadakID from jesthatapadaktran;
select JestotaMedal_ID from bn_jesthatapadak;

select j.SailorID, s.OFFICIALNUMBER
from sailor s
left join jesthatapadaktran j on j.SailorID = s.SAILORID
where s.SAILORSTATUS = 1;


SELECT jt.SailorID, jt.JesthataPadakTranID, jp.NAME Awards, DATE_FORMAT(jt.AwardDate, '%d-%m-%Y')AwardDate,
se.SHORT_NAME AuthorityShip, jt.AuthorityNumber, DATE_FORMAT(jt.AuthorityDate, '%d-%m-%Y')AuthorityDate, d.DAO_NO, cu.FULL_NAME EntryUser, DATE_FORMAT(jt.CRE_DT, '%d-%m-%Y')EntryDate, uu.FULL_NAME UpdateUser,
DATE_FORMAT(uu.UPD_DT, '%d-%m-%Y')UpdateDate
from jesthatapadaktran jt
left join bn_jesthatapadak jp on jp.JestotaMedal_ID = jt.JesthataPadakID
left join bn_ship_establishment se on se.SHIP_ESTABLISHMENTID = jt.ShipID
left join bn_dao d on d.DAO_ID = jt.DAOID
left join sa_users cu on cu.USER_ID = jt.CRE_BY
left join sa_users uu on uu.USER_ID = jt.UPD_BY
where jt.SailorID =  '250';

#4380
SELECT DATEDIFF('2019-01-06',ENTRYDATE) totalEntryDayes FROM sailor WHERE SAILORID = '7877' AND SAILORSTATUS = 1;

select * from jesthatapadaktran where SailorID = 7877 and JesthataPadakID = 1;

select * from jesthatapadaktran where SailorID = 7877 ORDER BY JesthataPadakTranID DESC LIMIT 1;


#select JesthataPadakID from jesthatapadaktran where SailorID = 7877 and JesthataPadakID in ( select JestotaMedal_ID from bn_jesthatapadak);

SELECT DATEDIFF('2019-01-06',jt.AwardDate) totalLastAwardDayes
FROM sailor s
LEFT JOIN jesthatapadaktran jt on jt.SailorID = s.SAILORID
WHERE jt.SailorID = '7877'
ORDER BY JesthataPadakTranID DESC LIMIT 1;

select * from jesthatapadaktran where SailorID = 5557;

delete from jesthatapadaktran where SailorID = 5557;


SELECT s.SAILORID, s.FULLNAME, r.RANK_ID, (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME, se.SHORT_NAME SHIP_ESTABLISHMENT, pu.NAME POSTING_UNIT_NAME, DATE_FORMAT(s.POSTINGDATE, '%d-%m-%Y') POSTING_DATE, TRIM(leading 0 FROM s.OFFICIALNUMBER)OFFICIALNUMBER,
       h.JesthataPadakID,h.AwardDate,h.AuthorityNumber,h.AuthorityDate,h.AuthorityName,h.DAONumber,h.ShipID,
        bh.NAME JESTHATA_PADAK_NAME
FROM jesthatapadaktran h
LEFT JOIN sailor s on s.SAILORID = h.SailorID
LEFT JOIN bn_rank r on r.RANK_ID = s.RANKID
LEFT JOIN bn_jesthatapadak bh on bh.JestotaMedal_ID = h.JesthataPadakID
LEFT JOIN bn_ship_establishment se on se.SHIP_ESTABLISHMENTID = h.SailorID
LEFT JOIN partii as p ON s.FIRSTPARTID = p.PartIIID
LEFT JOIN bn_posting_unit as pu ON pu.POSTING_UNITID = s.POSTINGUNITID
WHERE h.JesthataPadakTranID = 10860;


SELECT h.JesthataPadakID,h.AwardDate,h.AuthorityNumber,h.AuthorityDate,h.AuthorityName,h.DAONumber,
       s.SAILORID, s.FULLNAME, r.RANK_ID, (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME, sh.SHORT_NAME SHIP_ESTABLISHMENT, pu.NAME POSTING_UNIT_NAME, DATE_FORMAT(s.POSTINGDATE, '%d-%m-%Y') POSTING_DATE, TRIM(leading 0 FROM s.OFFICIALNUMBER)OFFICIALNUMBER
FROM jesthatapadaktran h
LEFT JOIN sailor s on s.SAILORID = h.sailorID
LEFT JOIN bn_posting_unit pu ON pu.POSTING_UNITID = s.POSTINGUNITID
LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
LEFT JOIN bn_ship_establishment sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
LEFT JOIN bn_rank r ON r.RANK_ID = s.RANKID
WHERE h.JesthataPadakTranID = 10861;



SELECT DATEDIFF('2019-01-06',ENTRYDATE) totalEntryDayes FROM sailor WHERE SAILORID = 5557;

select * from jesthatapadaktran where SailorID = 4042 and JesthataPadakID = 1;
select ENTRYDATE from sailor where OFFICIALNUMBER = 830221; #4042

SELECT DATEDIFF(curdate(),ENTRYDATE) totalJoiningDayes FROM sailor WHERE SAILORID = '4042';

SELECT DATEDIFF('2002-01-06',AwardDate) totalLastAwardDayes, AwardDate
FROM jesthatapadaktran
WHERE SailorID = 4042 and JesthataPadakID = 2;


SELECT DATEDIFF('2003-01-06',jt.AwardDate) totalLastAwardDayes, jt.AwardDate
FROM sailor s
LEFT JOIN jesthatapadaktran jt on jt.SailorID = s.SAILORID
WHERE jt.SailorID = '4042' and jt.JesthataPadakID = 1;



SELECT DATEDIFF('1990-01-06',ENTRYDATE) totalLastAwardDayes, ENTRYDATE
FROM sailor
WHERE SAILORID = 4042;


select abc.SailorID,abc.OFFICIALNUMBER
from
(select da.SailorID,s.OFFICIALNUMBER
from sailor s
left join daoamend da on da.SailorID = s.SAILORID
where s.SAILORSTATUS = 1) abc where abc.SailorID = 11293;

SELECT da.DAOAmendID, d.DAO_NO PreviousDao, do.DAO_NO AmendDao, sh.NAME AuthorityShip, da.AuthorityNumber, DATE_FORMAT(da.AuthorityDate, '%d-%m-%y')AuthorityDate, da.AmendText,
       cu.FULL_NAME CRE_BY, DATE_FORMAT(da.CRE_DT, '%d-%m-%Y') CRE_DT, uu.FULL_NAME UPD_BY, DATE_FORMAT(da.UPD_DT, '%d-%m-%Y') UPD_DT
from daoamend da
LEFT JOIN bn_dao d on d.DAO_ID = da.PreviousDAOID
LEFT JOIN bn_dao do on do.DAO_ID = da.DAOAmendID
LEFT JOIN bn_ship_establishment sh on sh.SHIP_ESTABLISHMENTID = da.ShipID
LEFT JOIN sa_users cu ON cu.USER_ID = da.CRE_BY
LEFT JOIN sa_users uu ON uu.USER_ID = da.UPD_BY
where da.SailorID = 11293;

select DAOAmendID from daoamend where SailorID = '5557';
select * from daoamend where SailorID = '5557' and AuthorityDate = '2019-01-07';

SELECT d.DAOAmendID, se.SHIP_ESTABLISHMENTID, pu.POSTING_UNITID, d.PreviousDAOID, d.PreviousDAONumber, d.CurrentDAOID, d.CurrentDAONumber, d.AuthorityNumber, date_format(d.AuthorityDate,'%d-%m-%Y') AuthorityDate, d.AmendText, d.ACTIVE_STATUS, d.CRE_BY, d.CRE_DT, d.UPD_BY, d.UPD_DT, d.ShipID,
s.SAILORID, s.FULLNAME, r.RANK_ID, (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME, se.SHORT_NAME SHIP_ESTABLISHMENT, pu.NAME POSTING_UNIT_NAME, DATE_FORMAT(s.POSTINGDATE, '%d-%m-%Y') POSTING_DATE, TRIM(leading 0 FROM s.OFFICIALNUMBER)OFFICIALNUMBER
FROM daoamend d
LEFT JOIN sailor s on s.SAILORID = d.SailorID
LEFT JOIN bn_rank r on s.RANKID = r.RANK_ID
LEFT JOIN bn_posting_unit pu on pu.POSTING_UNITID = d.ShipID
LEFT JOIN bn_ship_establishment se on se.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
where d.DAOAmendID = 227;


SELECT TIMESTAMPDIFF(MONTH,'2009-05-18','2009-07-29');

select TIMESTAMPDIFF(year,MarriageDate,current_timestamp()) from bn_roster;

select x.OFFICIALNUMBER, x.BIRTHDATE, x.MARITALSTATUS
from (select OFFICIALNUMBER,TIMESTAMPDIFF(year,BIRTHDATE,current_timestamp()) BIRTHDATE, MARITALSTATUS from sailor where SAILORID = '18808' and SAILORSTATUS = 1) x
where x.BIRTHDATE >= 26 and x.MARITALSTATUS = 1;

select SAILORID, SAILORSTATUS from sailor where OFFICIALNUMBER = 20140759;

SELECT s.SAILORID, s.FULLNAME, r.RANK_ID, (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME, sh.SHORT_NAME SHIP_ESTABLISHMENT, pu.NAME POSTING_UNIT_NAME, DATE_FORMAT(s.POSTINGDATE, '%d-%m-%Y') POSTING_DATE, TRIM(leading 0 FROM s.OFFICIALNUMBER)OFFICIALNUMBER
From sailor s
LEFT JOIN bn_posting_unit pu ON pu.POSTING_UNITID = s.POSTINGUNITID
LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
LEFT JOIN bn_ship_establishment sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
LEFT JOIN bn_rank r ON r.RANK_ID = s.RANKID;


select uws.SanctionNo, uws.Remarks, (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME
FROM unitwisesanction uws
LEFT JOIN bn_rank r ON r.RANK_ID = uws.RankID
LEFT JOIN partii p ON p.PartIIID = uws.PartIIID
where uws.PostingUnitID = ''
order by r.RANK_CODE asc;


select PartIIID, Name from partii where ACTIVE_STATUS = 1;

select * , count(sai.EQUIVALANTRANKID) as number
from sailor sai
left join bn_rank bnr on bnr.RANK_ID=sai.RANKID
left join partii part on part.PartIIID=sai.FIRSTPARTID
where part.PartIIID in (1,2,3,4) and sai.SHIPESTABLISHMENTID in (1,2,3,4)
group by sai.EQUIVALANTRANKID;


select SHIP_ESTABLISHMENTID, AREA_ID from bn_ship_establishment;


select RANK_CODE
from bn_rank;


select * from sailor where OFFICIALNUMBER = 890134;
select NomineeID from nominee where SailorID = 5557;

delete from nominee where SailorID = 5557;

select * from nominee where SailorID = '5557'; #14035


SELECT abc.SAILORID, abc.Name, abc.Relation, abc.RELATIONID, n.NomineeID,n.Percentage
FROM
(select SAILORID, FATHERNAME Name, 'Father' Relation, 4 RelationID from sailor where SAILORID = '5557'
union all
select SAILORID, MOTHERNAME Name, 'Mother' Relation, 1 RelationID from sailor where SAILORID = '5557'
union all
select SailorID SAILORID, SpouseName Name, 'Wife' Relation, 5 RelationID FROM marriage where SailorID = '5557' and MaritalStatus = 1
union all
select SailorID SAILORID, Name, (case when (Gender = 1) THEN 'Son' ELSE 'Daughter' END)Relation,
(case when (Gender = 1) THEN 7 ELSE 6 END)RelationID
from children where SailorID = '5557') abc
left JOIN nominee n ON abc.SAILORID = n.SailorID AND n.RelationID = abc.RELATIONID
WHERE abc.SAILORID = '5559' ORDER BY n.Percentage, abc.RELATIONID;


select FATHERNAME Name, 'Father' Relation, 4 RelationID from sailor where SAILORID = '5557'
union all
select MOTHERNAME Name, 'Mother' Relation, 1 RelationID from sailor where SAILORID = '5557'
union all
select SpouseName Name, 'Wife' Relation, 5 RelationID FROM marriage where SailorID = '5557' and MaritalStatus = 1
union all
select Name, (case when (Gender = 1) THEN 'Son' ELSE 'Daughter' END)Relation,
(case when (Gender = 1) THEN 7 ELSE 6 END)RelationID
from children where SailorID = '5557'
ORDER BY RELATIONID;

select RELATIONID from sailor;



select column_name, table_name from information_schema.columns where table_schema='bnsis_08112018' and column_name='SAILORID';

select * from information_schema.columns where table_schema='bnsis_08112018' and column_name='SAILORID';


select * from bn_relation;
select * from nominee;

select n.NomineeID, n.Percentage,n.Name NOMINEE_NAME, r.RELATION_ID, r.NAME RELATION
from nominee n
left join bn_relation r on r.RELATION_ID = n.RelationID where n.SailorID = 5557;


select PhotoPath, groupImg,wifeImg,PensionStatus from retirement where SailorID = 22438;
select MOBILE, NID from sailor where SAILORID = 22438;
select * from sailor where SAILORID = 22438;

SELECT SAILORID FROM sailor WHERE SAILORID = '22438' AND SAILORSTATUS = 1;
select SailorID, image_url from pensioner_child_images where SailorID = 22438;
SELECT count(*) is_exists FROM sailor WHERE SAILORID = '885557' AND SAILORSTATUS = 1;

select ENTRYDATE from sailor where SAILORID = 5557;
select AwardDate from jesthatapadaktran where SailorID = 5557;
select JesthataPadakTranID,JesthataPadakID from jesthatapadaktran where SailorID = 5557 and JesthataPadakID = 1 and JesthataPadakTranID != 10877;


SELECT sh.NAME ShipName, fc.NAME FrCategory, f.DetailID, f.SailorID, f.AuthorityName, f.TranStatus, DATE_FORMAT(f.TranDate, '%d-%m-%Y') EfficenDate, f.AuthorityNumber, DATE_FORMAT(f.AuthorityDate, '%d-%m-%Y')AuthorityDate, cu.FULL_NAME CRE_BY, DATE_FORMAT(f.CRE_DT, '%d-%m-%Y') CRE_DT, uu.FULL_NAME UPD_BY, DATE_FORMAT(f.UPD_DT, '%d-%m-%Y') UPD_DT
FROM fraudulentinfo f
LEFT JOIN bn_ship_establishment sh ON sh.SHIP_ESTABLISHMENTID = f.ShipID
LEFT JOIN bn_fraudulentcategory fc ON fc.CATEGORY_ID = f.CategoryID
LEFT JOIN sa_users cu ON cu.USER_ID = f.CRE_BY
LEFT JOIN sa_users uu ON uu.USER_ID = f.UPD_BY
where f.SailorID = 5557;

select SAILORSTATUS from sailor where SAILORSTATUS = 1;


SELECT s.*, se.NAME SHIP_ESTABLISHMENT, r.RANK_NAME, pu.NAME POSTING_UNIT_NAME, DATE_FORMAT(s.POSTINGDATE, "%d-%m-%Y") POSTING_DATE
FROM sailor as s
  LEFT JOIN bn_posting_unit as pu ON pu.POSTING_UNITID = s.POSTINGUNITID
  LEFT JOIN bn_rank as r ON r.RANK_ID = s.RANKID
  LEFT JOIN bn_ship_establishment as se ON se.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
WHERE s.OFFICIALNUMBER = '00890134';


SELECT s.SAILORID, TRIM(leading 0 FROM s.OFFICIALNUMBER )OFFICIALNUMBER, s.FULLNAME, sh.SHORT_NAME,mc.MedicalCategoryName,
       (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME,'(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME
FROM sailor s
LEFT JOIN bn_posting_unit as pu ON pu.POSTING_UNITID = s.POSTINGUNITID
LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
LEFT JOIN medicalcategory mc ON mc.MedicalCategoryID = s.MEDICALCATEGORY
LEFT JOIN bn_ship_establishment sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
WHERE s.SAILORID = 5557;

select AuthorityName,SailorID, PftDate, DAONumber, DAOID
from pfttran where SailorID = 5557;

select DAO_ID, DAO_NO from bn_dao;

select *
from medicalcategory;

select MEDICALCATEGORY, MEDICALCATEGORYID
from sailor where SAILORID = 5557;

select * from sailor where SAILORSTATUS = 1;

ALTER TABLE pfttran
MODIFY AuthorityName varchar(100) null;

select * from bn_dao;


select *
from bn_navytraininghierarchy;





SELECT DISTINCT s.OFFICIALNUMBER O_No, s.FULLNAME NAME, r.RANK_NAME Rank, s.BRANCHID, s.RANKID, bpu.NAME present_unit,
date_format(s.POSTINGDATE, '%d-%m-%Y') AS Date_Of_Posting,
(SELECT bpu.NAME FROM bn_posting_unit bpu WHERE t.PostingUnitID = bpu.POSTING_UNITID) Under_Draft_unit, date_format(t.TODate, '%d-%m-%Y') AS Order_date
FROM sailor s
LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
LEFT JOIN transfer t ON s.SAILORID = t.SailorID
LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
LEFT JOIN bn_trade td ON s.BRANCHID = td.BRANCH_ID
LEFT JOIN partii p ON td.TRADE_ID = p.TradeID
WHERE s.SAILORSTATUS = 1 AND s.ZONEID IN (1) AND s.AREAID IN (5) AND p.PartIIID NOT IN (19) AND dao.GROUP_ID IN (1,2,3,4,5,7)
ORDER BY r.POSITION;


select s.SAILORID from sailor s where s.OFFICIALNUMBER = '00890134' AND s.SAILORSTATUS = 1;

select count(*) record_exists from engagement where EngagementNo = 0 and SailorID = 5557;

select SailorID, EngagementNo from engagement where SailorID = 5557;


#//////////////////////////////////////////////////////////////////////////////////////

SELECT a.Branch, sum(a.HLT) hlt,
sum(a.HLT1) hlt1, sum(a.HSLT) hslt,
sum(a.HSLT1) hslt1, sum(a.MCPO) mcpo,
sum(a.MCPO1) mcpo1, sum(a.SCPO) scpo,
sum(a.SCPO1) scpo1, sum(a.CPO) cpo,
sum(a.CPO1) cpo1, sum(a.PO) po,
sum(a.PO1) po1, sum(a.LDG) ldg,
sum(a.LDG1) ldg1, sum(a.AB) ab,
sum(a.AB1) ab1, sum(a.OD) od,
sum(a.OD1) od1, sum(a.ODUT) odut,
sum(a.ODUT1) odut1, sum(a.DEUC) deuc,
sum(a.DEUC1) deuc1,
(sum(a.HLT1) + sum(a.HSLT1) +  sum(a.MCPO1) +  sum(a.SCPO1) +  sum(a.CPO1) +  sum(a.PO1) +  sum(a.LDG1) +  sum(a.AB1) +  sum(a.OD1) +  sum(a.ODUT1) +  sum(a.DEUC1)) TotalNN,
(a.HLT + a.HSLT + a.MCPO + a.SCPO + a.CPO + a.PO + a.LDG + a.AB + a.OD + a.ODUT + a.DEUC) Total
FROM  (SELECT (SELECT b.BRANCH_NAME
                 FROM  bn_branch b
                 WHERE r.BRANCH_ID = b.BRANCH_ID)
                  AS Branch,
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 11 THEN 1 ELSE NULL END) AS 'HLT',
                0 'HLT1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 1 THEN 1 ELSE NULL END) AS 'HSLT',
                0 'HSLT1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 2 THEN 1 ELSE NULL END) AS 'MCPO',
                0 'MCPO1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 10 THEN 1 ELSE NULL END) AS 'SCPO',
                0 'SCPO1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 3 THEN 1 ELSE NULL END) AS 'CPO',
                0 'CPO1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 4 THEN 1 ELSE NULL END) AS 'PO',
                0 'PO1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 5 THEN 1 ELSE NULL END) AS 'LDG',
                0 'LDG1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 6 THEN 1 ELSE NULL END) AS 'AB',
                0 'AB1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 7 THEN 1 ELSE NULL END) AS 'OD',
                0 'OD1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 8 THEN 1 ELSE NULL END) AS 'ODUT',
                0 'ODUT1',
                COUNT(CASE WHEN r.EQUIVALANT_RANKID = 9 THEN 1 ELSE NULL END) AS 'DEUC',
                0 'DEUC1',
                r.BRANCH_ID
     FROM     sailor s
     LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
     -- LEFT JOIN bn_trade td ON s.BRANCHID = td.BRANCH_ID
     -- LEFT JOIN partii p ON td.TRADE_ID = p.TradeID
     LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
     LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
     LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
     LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
     WHERE s.SAILORSTATUS = 1   AND dao.GROUP_ID IN (1,2,3,4,5,7)
     GROUP BY r.BRANCH_ID
     UNION
     SELECT (SELECT b.BRANCH_NAME
                 FROM   bn_branch b
                 WHERE  r.BRANCH_ID = b.BRANCH_ID)
                  AS Branch,
                0 'HLT',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 11 THEN SanctionNo ELSE 0 END) AS 'HLT1',
                0 'HSLT',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 1 THEN SanctionNo ELSE 0 END) AS 'HSLT1',
                0 'MCPO',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 2 THEN SanctionNo ELSE 0 END) AS 'MCPO1',
                0 'SCPO',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 10 THEN SanctionNo ELSE 0 END) AS 'SCPO1',
                0 'CPO',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 3 THEN SanctionNo ELSE 0 END) AS 'CPO1',
                0 'PO',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 4 THEN SanctionNo ELSE 0 END) AS 'PO1',
                0 'LDG',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 5 THEN SanctionNo ELSE 0 END) AS 'LDG1',
                0 'AB',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 6 THEN SanctionNo ELSE 0 END) AS 'AB1',
                0 'OD',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 7 THEN SanctionNo ELSE 0 END) AS 'OD1',
                0 'ODUT',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 8 THEN SanctionNo ELSE 0 END) AS 'ODUT1',
                0 'DEUC',
                sum(CASE WHEN r.EQUIVALANT_RANKID = 9 THEN SanctionNo ELSE 0 END) AS 'DEUC1',
                r.BRANCH_ID
     FROM     unitwisesanction s
     INNER JOIN bn_rank r ON s.RANKID = r.RANK_ID
     LEFT JOIN bn_branch b ON r.BRANCH_ID = b.BRANCH_ID
     LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
     LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
     LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
     WHERE  UnitWiseSanctionID is not null
     GROUP BY r.BRANCH_ID) a
GROUP BY a.BRANCH_ID;


select *,PARENT_ID,NAME,ADMIN_ID from bn_navyadminhierarchy where ACTIVE_STATUS = 1 order by CODE asc;
select SHIP_ESTABLISHMENTID from bn_posting_unit where ACTIVE_STATUS = 1 order by CODE asc;

#zone
select * from bn_navyadminhierarchy where ACTIVE_STATUS = 1 and ADMIN_TYPE = 1 order by CODE asc;

#area
select * from bn_navyadminhierarchy where ACTIVE_STATUS = 1 and ADMIN_TYPE = 2 AND PARENT_ID =  order by CODE asc;

#ship
select *, AREA_ID from bn_ship_establishment where ACTIVE_STATUS = 1 order by CODE asc;


SELECT * FROM sailor WHERE RANKID = 1 AND OFFICIALNUMBER = 1;

SELECT BRANCH_TYPE, BRANCH_ID, BRANCH_CODE, BRANCH_NAME FROM bn_branch ;
select * from bn_rank;

SELECT b.BRANCH_NAME, r.RANK_ID,r.RANK_NAME,r.BRANCH_ID,r.SANCTION_NUMBER
FROM bn_rank r
LEFT JOIN bn_branch b on b.BRANCH_ID = r.BRANCH_ID
WHERE b.BRANCH_ID IN (1,2) order by r.RANK_ID asc;


select BRANCH_ID, RANK_NAME, sa.sanction, b.borne
from bn_rank r
left join (select us.RankID, count(us.RankID)sanction from unitwisesanction us group by us.RankID) sa on r.RANK_ID = sa.RankID
left join (select s.RANKID, count(s.RANKID)borne from sailor s group by s.RANKID) b on r.RANK_ID = b.RANKID
where r.BRANCH_ID in(1,2)
order by r.BRANCH_ID, r.POSITION;


SELECT count(r.BRANCH_ID)TOTAL_RANK,b.BRANCH_NAME,r.BRANCH_ID
FROM bn_rank r
LEFT JOIN bn_branch b on b.BRANCH_ID = r.BRANCH_ID
WHERE b.BRANCH_ID IN (1,2) group by r.BRANCH_ID order by r.BRANCH_ID asc;


select * from bn_organization_hierarchy where ACTIVE_STATUS = 1 and ORG_TYPE = 3;


select *
from bn_roster
where SailorID = '5557';

delete from bn_roster where SailorID = '5557';


#Branch And Rank Wise Section
select BRANCH_ID, RANK_NAME, sa.sanction, b.borne
from bn_rank r
left join (select us.RankID, sum(us.SanctionNo)sanction from unitwisesanction us group by us.RankID) sa on r.RANK_ID = sa.RankID
left join (select s.RANKID, count(s.SAILORID)borne from sailor s where s.SAILORSTATUS = 1 group by s.RANKID) b on r.RANK_ID = b.RANKID
where r.BRANCH_ID in(1,2)
order by r.BRANCH_ID, r.POSITION;


select BRANCH_ID, RANK_NAME, sa.sanction, b.borne
from bn_rank r
left join (select us.RankID, count(us.RankID)sanction from unitwisesanction us group by us.RankID) sa on r.RANK_ID = sa.RankID
left join (select s.RANKID, count(s.RANKID)borne from sailor s group by s.RANKID) b on r.RANK_ID = b.RANKID
where r.BRANCH_ID in(1,2)
order by r.BRANCH_ID, r.POSITION;


select * from sailor where OFFICIALNUMBER in (890134,20050484,20140159);

# official no, rank, sailorid, ship_establishment
SELECT s.ACTIVE_STATUS, s.SAILORID, s.FULLNAME,s.SENIORITYDATE, r.RANK_ID, (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME, sh.SHORT_NAME SHIP_ESTABLISHMENT, pu.NAME POSTING_UNIT_NAME, DATE_FORMAT(s.POSTINGDATE, '%d-%m-%Y') POSTING_DATE, TRIM(leading 0 FROM s.OFFICIALNUMBER)OFFICIALNUMBER
FROM sailor s
LEFT JOIN bn_posting_unit pu ON pu.POSTING_UNITID = s.POSTINGUNITID
LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
LEFT JOIN bn_ship_establishment sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
LEFT JOIN bn_rank r ON r.RANK_ID = s.RANKID
where SAILORID in (5557, 14035, 3316) and s.ACTIVE_STATUS = 1;


#Organization Wise sanction & borne Query

select t.ORG_ID,t.EQUIVALANT_RANKID, er.RANK_NAME, sum(t.sanction) sanction, sum(t.borne) borne

from (select p.ORG_ID,r.EQUIVALANT_RANKID, sum(us.SanctionNo) sanction,0 borne
      from unitwisesanction us
      left join bn_posting_unit p on p.POSTING_UNITID = us.PostingUnitID
      left join bn_rank r on us.RankID = r.RANK_ID
      group by p.ORG_ID, r.EQUIVALANT_RANKID
      union
      Select p.ORG_ID,s.EQUIVALANTRANKID,0 sanction, count(s.SAILORID) borne
      from sailor s
      left join bn_posting_unit p on s.POSTINGUNITID = p.POSTING_UNITID
      where s.SAILORSTATUS = 1
      group by p.ORG_ID, s.EQUIVALANTRANKID) t

left join bn_equivalent_rank er on t.EQUIVALANT_RANKID = er.EQUIVALANT_RANKID
where t.ORG_ID in (63, 64)
group by t.ORG_ID,t.EQUIVALANT_RANKID
order by t.ORG_ID, er.POSITION;



select count(t.ORG_ID) TOTAL_EQU_RANK, t.ORG_ID, bnh.ORG_NAME
from (select p.ORG_ID,r.EQUIVALANT_RANKID, sum(us.SanctionNo) sanction,0 borne
     from unitwisesanction us
     left join bn_posting_unit p on p.POSTING_UNITID = us.PostingUnitID
     left join bn_rank r on us.RankID = r.RANK_ID
     group by p.ORG_ID, r.EQUIVALANT_RANKID
     union
     Select p.ORG_ID,s.EQUIVALANTRANKID,0 sanction, count(s.SAILORID) borne
     from sailor s
     left join bn_posting_unit p on s.POSTINGUNITID = p.POSTING_UNITID
     where s.SAILORSTATUS = 1
     group by p.ORG_ID, s.EQUIVALANTRANKID) t

left join bn_equivalent_rank er on t.EQUIVALANT_RANKID = er.EQUIVALANT_RANKID
left join bn_organization_hierarchy bnh on bnh.ORG_ID = t.ORG_ID
where t.ORG_ID in (63,64,65) and bnh.ORG_TYPE = 3 and bnh.ACTIVE_STATUS = 1
group by t.ORG_ID
order by t.ORG_ID;



select a.ORG_ID, count(a.EQUIVALANT_RANKID)TotalRank, oh.ORG_NAME
from
       (select t.ORG_ID,t.EQUIVALANT_RANKID, er.RANK_NAME, sum(t.sanction) sanction, sum(t.borne) borne

from (select p.ORG_ID,r.EQUIVALANT_RANKID, sum(us.SanctionNo) sanction,0 borne
      from unitwisesanction us
      left join bn_posting_unit p on p.POSTING_UNITID = us.PostingUnitID
      left join bn_rank r on us.RankID = r.RANK_ID
      group by p.ORG_ID, r.EQUIVALANT_RANKID
      union
      Select p.ORG_ID,s.EQUIVALANTRANKID,0 sanction, count(s.SAILORID) borne
      from sailor s
      left join bn_posting_unit p on s.POSTINGUNITID = p.POSTING_UNITID
      where s.SAILORSTATUS = 1
      group by p.ORG_ID, s.EQUIVALANTRANKID) t

left join bn_equivalent_rank er on t.EQUIVALANT_RANKID = er.EQUIVALANT_RANKID
where t.ORG_ID in (63, 64)
group by t.ORG_ID,t.EQUIVALANT_RANKID
order by t.ORG_ID, er.POSITION)a
left join bn_organization_hierarchy oh on a.ORG_ID = oh.ORG_ID
group by a.ORG_ID;

