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
select * from bn_navyadminhierarchy where ACTIVE_STATUS = 1 and ADMIN_TYPE = 1 order by CODE asc; # admin_id = zone based on type

#area
select * from bn_navyadminhierarchy where ACTIVE_STATUS = 1 and ADMIN_TYPE = 2 AND PARENT_ID = 1 order by CODE asc; # admin_id = area & parent_id = zone based on type

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
SELECT s.SAILORSTATUS, s.SAILORID, s.FULLNAME,s.SENIORITYDATE, r.RANK_ID, (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME, sh.SHORT_NAME SHIP_ESTABLISHMENT, pu.NAME POSTING_UNIT_NAME, DATE_FORMAT(s.POSTINGDATE, '%d-%m-%Y') POSTING_DATE, TRIM(leading 0 FROM s.OFFICIALNUMBER)OFFICIALNUMBER
FROM sailor s
LEFT JOIN bn_posting_unit pu ON pu.POSTING_UNITID = s.POSTINGUNITID
LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
LEFT JOIN bn_ship_establishment sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
LEFT JOIN bn_rank r ON r.RANK_ID = s.RANKID
where SAILORID in (5557, 14035, 3316) and s.SAILORSTATUS = 1;


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



SELECT DISTINCT s.OFFICIALNUMBER O_No, s.FULLNAME NAME, r.RANK_NAME Rank, s.BRANCHID, s.RANKID, bpu.NAME present_unit,
 date_format(s.POSTINGDATE, '%d-%m-%Y') AS Date_Of_Posting,
 (SELECT bpu.NAME FROM bn_posting_unit bpu WHERE  t.PostingUnitID = bpu.POSTING_UNITID) Under_Draft_unit, date_format(t.TODate, '%d-%m-%Y') AS Order_date
FROM sailor s
 LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
 LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
 LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
 LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
 LEFT JOIN transfer t ON s.SAILORID = t.SailorID
 LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
 LEFT JOIN bn_trade td ON s.BRANCHID = td.BRANCH_ID
 LEFT JOIN partii p ON td.TRADE_ID = p.TradeID
WHERE s.SAILORSTATUS = 1  AND s.ZONEID IN (1)   AND dao.GROUP_ID IN (1)
ORDER BY r.POSITION;



SELECT DISTINCT s.OFFICIALNUMBER O_No, s.FULLNAME NAME, r.RANK_NAME Rank, s.BRANCHID, s.RANKID, bpu.NAME present_unit,
        date_format(s.POSTINGDATE, '%d-%m-%Y') AS Date_Of_Posting,
        (SELECT bpu.NAME FROM bn_posting_unit bpu WHERE  t.PostingUnitID = bpu.POSTING_UNITID) Under_Draft_unit, date_format(t.TODate, '%d-%m-%Y') AS Order_date
    FROM sailor s
        LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
        LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
        LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
        LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
        LEFT JOIN transfer t ON s.SAILORID = t.SailorID
        LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
        LEFT JOIN bn_trade td ON s.BRANCHID = td.BRANCH_ID
        LEFT JOIN partii p ON td.TRADE_ID = p.TradeID
    WHERE s.SAILORSTATUS = 1  AND dao.GROUP_ID IN (1,2,3,4,5,7)
    ORDER BY r.POSITION;



SELECT DISTINCT s.OFFICIALNUMBER O_No, s.FULLNAME NAME,
                (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) RankName,
                s.BRANCHID, s.RANKID, bpu.NAME present_unit,
        date_format(s.POSTINGDATE, '%d-%m-%Y') AS Date_Of_Posting,
        (SELECT bpu.NAME FROM bn_posting_unit bpu WHERE  t.PostingUnitID = bpu.POSTING_UNITID) Under_Draft_unit, date_format(t.TODate, '%d-%m-%Y') AS Order_date
    FROM sailor s
        LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
        LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
        LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
        LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
        LEFT JOIN transfer t ON s.SAILORID = t.SailorID
        LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
        LEFT JOIN partii p ON s.FIRSTPARTID = p.PartIIID
    WHERE s.SAILORSTATUS = 1  AND s.FIRSTPARTID IN (1)   AND dao.GROUP_ID IN (1,2,3,4,5,7)
    ORDER BY s.OFFICIALNUMBER asc

;

#r.RANK_NAME Rank,
SELECT  (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME
FROM sailor s
LEFT JOIN bn_posting_unit pu ON pu.POSTING_UNITID = s.POSTINGUNITID
LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
LEFT JOIN bn_ship_establishment sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
LEFT JOIN bn_rank r ON r.RANK_ID = s.RANKID
where SAILORID in (5557, 14035, 3316) and s.ACTIVE_STATUS = 1;



SELECT a.Division, a.totalDis, a.District, a.HLT, a.HSLT, a.MCPO, a.SCPO, a.CPO, a.PO, a.LDG, a.AB, a.OD, a.ODUT, a.DEUC, (a.HLT + a.HSLT + a.MCPO + a.SCPO + a.CPO + a.PO + a.LDG + a.AB + a.OD + a.ODUT + a.DEUC) Total
from (select    (select bd.NAME from   bn_bdadminhierarchy bd where  bd.BD_ADMINID = s.DIVISIONID) as Division,
        (select count(bd.BD_ADMINID) from   bn_bdadminhierarchy bd where  bd.PARENT_ID = s.DIVISIONID) as totalDis,
        (select bd.NAME from   bn_bdadminhierarchy bd where  bd.BD_ADMINID = s.DISTRICTID) as District,
        b.DAO_GROUPID as GROUP_ID,
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 11 THEN 1 ELSE NULL END) AS 'HLT',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 1 THEN 1 ELSE NULL END) AS 'HSLT',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 2 THEN 1 ELSE NULL END) AS 'MCPO',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 10 THEN 1 ELSE NULL END) AS 'SCPO',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 3 THEN 1 ELSE NULL END) AS 'CPO',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 4 THEN 1 ELSE NULL END) AS 'PO',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 5 THEN 1 ELSE NULL END) AS 'LDG',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 6 THEN 1 ELSE NULL END) AS 'AB',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 7 THEN 1 ELSE NULL END) AS 'OD',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 8 THEN 1 ELSE NULL END) AS 'ODUT',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 9 THEN 1 ELSE NULL END) AS 'DEUC'
FROM     sailor s, bn_rank r, bn_branch b
WHERE    s.RANKID = r.RANK_ID AND  s.BRANCHID = b.BRANCH_ID AND s.SAILORSTATUS = 1  AND s.RANKID IN (1)
GROUP by s.DIVISIONID, s.DISTRICTID) a
WHERE  a.Division is not null  AND a.GROUP_ID IN (1,2,3,4,5,7);


##########

SELECT a.Division, a.totalDis, a.District, a.HLT, a.HSLT, a.MCPO, a.SCPO, a.CPO, a.PO, a.LDG, a.AB, a.OD, a.ODUT, a.DEUC, (a.HLT + a.HSLT + a.MCPO + a.SCPO + a.CPO + a.PO + a.LDG + a.AB + a.OD + a.ODUT + a.DEUC) Total
  from (select    (select bd.NAME from   bn_bdadminhierarchy bd where  bd.BD_ADMINID = s.DIVISIONID) as Division,
        (select count(bd.BD_ADMINID) from  bn_bdadminhierarchy bd where  bd.PARENT_ID = s.DIVISIONID) as totalDis,
        (select bd.NAME from  bn_bdadminhierarchy bd where  bd.BD_ADMINID = s.DISTRICTID) as District,
        b.DAO_GROUPID as GROUP_ID,
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 11 THEN 1 ELSE NULL END) AS 'HLT',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 1 THEN 1 ELSE NULL END) AS 'HSLT',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 2 THEN 1 ELSE NULL END) AS 'MCPO',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 10 THEN 1 ELSE NULL END) AS 'SCPO',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 3 THEN 1 ELSE NULL END) AS 'CPO',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 4 THEN 1 ELSE NULL END) AS 'PO',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 5 THEN 1 ELSE NULL END) AS 'LDG',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 6 THEN 1 ELSE NULL END) AS 'AB',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 7 THEN 1 ELSE NULL END) AS 'OD',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 8 THEN 1 ELSE NULL END) AS 'ODUT',
         COUNT(CASE WHEN r.EQUIVALANT_RANKID = 9 THEN 1 ELSE NULL END) AS 'DEUC'
FROM     sailor s, bn_rank r, bn_branch b
WHERE    s.RANKID = r.RANK_ID AND  s.BRANCHID = b.BRANCH_ID AND s.SAILORSTATUS = 1  AND s.RANKID IN (1)
GROUP by s.DIVISIONID, s.DISTRICTID) a
WHERE  a.Division is not null  AND a.GROUP_ID IN (1,2,3,4,5,7)
;


############
SELECT a.STUDENT_ID,a.FULL_NAME_EN,(SELECT COUNT(*)  FROM UMS_LAB_SCHEDULE WHERE STUDENT_ID=a.STUDENT_ID ) IS_EXIST FROM STUDENT_PERSONAL_INFO a;

###

SELECT  TRIM(leading 0 FROM s.OFFICIALNUMBER)OFFICIALNUMBER, s.FULLNAME, s.MAXGCB, s.SAILORID, s.ENTRYDATE, s.MOBILE, (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME, p.Name PARTII_NAME
FROM sailor s
LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
LEFT JOIN bn_rank r ON r.RANK_ID = s.RANKID
where SAILORID in (5557, 14035, 3316) and s.SAILORSTATUS = 1;



select *
from partii;


SELECT s.SAILORID, s.FULLNAME, p.Name
FROM sailor s
LEFT JOIN partii p ON p.PartIIID = s.FIRSTPARTID
where SAILORID in (5557, 14035, 3316) and s.ACTIVE_STATUS = 1;


select * from bn_organization_hierarchy where ACTIVE_STATUS = 1 and ORG_TYPE = 3;

select *,ACTIVE_STATUS
from bn_branch;

SELECT   b.BRANCH_NAME AS Branch, r.RANK_NAME AS Rank, p.Name AS Part, count(uws.SanctionNo) AS sanc, pro.Borne, uws.Remarks
  FROM  bn_branch b
           LEFT JOIN bn_rank r ON b.BRANCH_ID = r.BRANCH_ID
           LEFT JOIN unitwisesanction uws ON r.RANK_ID = uws.RankID
           LEFT JOIN partii p ON uws.PartIIID = p.PartIIID
           -- LEFT JOIN bn_organization_hierarchy bno ON bno.ORG_ID = b.ORG_ID
           LEFT JOIN promotionrosterdata pro ON uws.RankID = pro.RankID AND b.BRANCH_ID = pro.BranchID
  GROUP BY b.BRANCH_ID, r.RANK_ID, p.PartIIID
  ORDER BY b.BRANCH_ID, r.POSITION, p.PartIIID
;


SELECT a.Division, a.District, a.Branch, a.totalDiv, a.HLT, a.HSLT, a.MCPO, a.SCPO, a.CPO, a.PO, a.LDG, a.AB, a.OD, a.ODUT, a.DEUC, (a.HLT + a.HSLT + a.MCPO + a.SCPO + a.CPO + a.PO + a.LDG + a.AB + a.OD + a.ODUT + a.DEUC) Total
FROM   (SELECT   (SELECT bd.NAME FROM   bn_bdadminhierarchy bd WHERE  bd.BD_ADMINID = s.DIVISIONID) AS Division,
       (SELECT bd.NAME FROM   bn_bdadminhierarchy bd WHERE  bd.BD_ADMINID = s.DISTRICTID) AS District,
       (select count(bd.BD_ADMINID) from   bn_bdadminhierarchy bd where  bd.PARENT_ID = s.DIVISIONID) as totalDiv,
       b.BRANCH_NAME AS Branch,
       s.DISTRICTID,
       b.DAO_GROUPID AS GROUP_ID,
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 11 THEN 1 ELSE NULL END) AS 'HLT',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 1 THEN 1 ELSE NULL END) AS 'HSLT',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 2 THEN 1 ELSE NULL END) AS 'MCPO',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 10 THEN 1 ELSE NULL END) AS 'SCPO',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 3 THEN 1 ELSE NULL END) AS 'CPO',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 4 THEN 1 ELSE NULL END) AS 'PO',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 5 THEN 1 ELSE NULL END) AS 'LDG',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 6 THEN 1 ELSE NULL END) AS 'AB',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 7 THEN 1 ELSE NULL END) AS 'OD',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 8 THEN 1 ELSE NULL END) AS 'ODUT',
       COUNT(CASE WHEN r.EQUIVALANT_RANKID = 9 THEN 1 ELSE NULL END) AS 'DEUC'
FROM     sailor s, bn_rank r, bn_branch b
WHERE    s.RANKID = r.RANK_ID AND s.BRANCHID = b.BRANCH_ID AND s.SAILORSTATUS = 1  AND s.RANKID IN (1)
GROUP BY s.DIVISIONID, s.DISTRICTID, s.BRANCHID) a
WHERE  a.Division IS NOT NULL  AND a.GROUP_ID IN (1,2,3,4,5,7);




select sum(X.sanc)
from
(SELECT b.BRANCH_NAME AS Branch, r.RANK_NAME AS Rank, p.Name AS Part, count(uws.SanctionNo) AS sanc, pro.Borne, uws.Remarks
FROM  bn_branch b
      LEFT JOIN bn_rank r ON b.BRANCH_ID = r.BRANCH_ID
      LEFT JOIN unitwisesanction uws ON r.RANK_ID = uws.RankID
      LEFT JOIN partii p ON uws.PartIIID = p.PartIIID
      LEFT JOIN promotionrosterdata pro ON uws.RankID = pro.RankID AND b.BRANCH_ID = pro.BranchID
      LEFT JOIN bn_daogroup a ON b.DAO_GROUPID = a.GROUP_ID
WHERE b.ACTIVE_STATUS = 1   AND a.GROUP_ID IN (1,2,3,4,5,7)
GROUP BY b.BRANCH_ID, r.RANK_ID, p.PartIIID, uws.SanctionNo
ORDER BY b.BRANCH_ID, r.POSITION, p.PartIIID) X
;


SELECT SUM(M.SANC)
FROM(SELECT b.BRANCH_NAME AS Branch, r.RANK_NAME AS Rank, p.Name AS Part, count(uws.SanctionNo) AS sanc, pro.Borne, uws.Remarks
FROM  bn_branch b
      LEFT JOIN bn_rank r ON b.BRANCH_ID = r.BRANCH_ID
      LEFT JOIN unitwisesanction uws ON r.RANK_ID = uws.RankID
      LEFT JOIN partii p ON uws.PartIIID = p.PartIIID
      LEFT JOIN promotionrosterdata pro ON uws.RankID = pro.RankID AND b.BRANCH_ID = pro.BranchID
      LEFT JOIN bn_daogroup a ON b.DAO_GROUPID = a.GROUP_ID
WHERE b.ACTIVE_STATUS = 1
      AND a.GROUP_ID IN (1,2,3,4,5,7)
GROUP BY b.BRANCH_NAME,r.RANK_NAME, p.Name, pro.Borne, uws.Remarks
) M;


SELECT b.BRANCH_NAME AS Branch, r.RANK_NAME AS Rank, p.Name AS Part, count(uws.SanctionNo) AS sanc, pro.Borne, uws.Remarks
FROM  bn_branch b
      LEFT JOIN bn_rank r ON b.BRANCH_ID = r.BRANCH_ID
      LEFT JOIN unitwisesanction uws ON r.RANK_ID = uws.RankID
      LEFT JOIN partii p ON uws.PartIIID = p.PartIIID
      LEFT JOIN promotionrosterdata pro ON uws.RankID = pro.RankID AND b.BRANCH_ID = pro.BranchID
      LEFT JOIN bn_daogroup a ON b.DAO_GROUPID = a.GROUP_ID
WHERE b.ACTIVE_STATUS = 1
      AND a.GROUP_ID IN (1,2,3,4,5,7)
GROUP BY b.BRANCH_NAME,r.RANK_NAME, p.Name, pro.Borne, uws.Remarks




select b.BRANCH_NAME AS Branch, r.RANK_NAME AS Rank, p.Name AS Part, count(uws.SanctionNo) AS sanc, pro.Borne, uws.Remarks
from bn_branch b,unitwisesanction uws,bn_rank r,partii p,promotionrosterdata pro,bn_daogroup a
where b.BRANCH_ID=r.BRANCH_ID
and b.BRANCH_ID=pro.BranchID
and b.DAO_GROUPID=a.GROUP_ID
and b.BRANCH_ID=r.BRANCH_ID
and uws.RankID=r.RANK_ID
and uws.PartIIID=p.PartIIID
and uws.PostingUnitID=pro.PostingUnitID
and a.GROUP_ID IN (1,2,3,4,5,7);


select br.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, sa.sanction sanc, b.Borne, sa.Remarks
from bn_rank r
left join (select us.RankID, us.PartIIID, sum(us.SanctionNo)sanction, us.Remarks from unitwisesanction us group by us.RankID,us.PartIIID) sa on r.RANK_ID = sa.RankID
left join (select s.RANKID, s.FIRSTPARTID, count(s.SAILORID)borne from sailor s where s.SAILORSTATUS = 1 group by s.RANKID,s.FIRSTPARTID) b on r.RANK_ID = b.RANKID
left join bn_branch br on r.BRANCH_ID = br.BRANCH_ID
left join partii p on p.PartIIID = b.FIRSTPARTID
left join bn_daogroup a ON br.DAO_GROUPID = a.GROUP_ID
where  r.ACTIVE_STATUS = 1 and r.BRANCH_ID in(1)
order by r.BRANCH_ID, r.POSITION
;


select us.RankID, us.PartIIID, sum(us.SanctionNo)sanction, us.Remarks from unitwisesanction us group by us.RankID,us.PartIIID;


SELECT b.BRANCH_NAME AS Branch, r.RANK_NAME AS Rank, p.Name AS Part, count(uws.SanctionNo) AS sanc, pro.Borne, uws.Remarks
FROM  bn_branch b
      LEFT JOIN bn_rank r ON b.BRANCH_ID = r.BRANCH_ID
      LEFT JOIN unitwisesanction uws ON r.RANK_ID = uws.RankID
      LEFT JOIN partii p ON uws.PartIIID = p.PartIIID
      LEFT JOIN promotionrosterdata pro ON uws.RankID = pro.RankID AND b.BRANCH_ID = pro.BranchID
      LEFT JOIN bn_daogroup a ON b.DAO_GROUPID = a.GROUP_ID
WHERE b.ACTIVE_STATUS = 1
      AND a.GROUP_ID IN (1,2,3,4,5,7)
GROUP BY b.BRANCH_NAME,r.RANK_NAME, p.Name, pro.Borne, uws.Remarks



SELECT a.Branch, a.BRANCH_ID, a.HLT, a.HSLT, a.MCPO, a.SCPO, a.CPO, a.PO, a.LDG, a.AB, a.OD,
    a.ODUT, a.DEUC, (a.HLT + a.HSLT + a.MCPO + a.SCPO + a.CPO + a.PO + a.LDG + a.AB + a.OD + a.ODUT + a.DEUC) Total
FROM (SELECT  b.BRANCH_NAME Branch, r.BRANCH_ID,
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 11 THEN 1 ELSE NULL END) AS 'HLT',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 1 THEN 1 ELSE NULL END) AS 'HSLT',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 2 THEN 1 ELSE NULL END) AS 'MCPO',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 10 THEN 1 ELSE NULL END) AS 'SCPO',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 3 THEN 1 ELSE NULL END) AS 'CPO',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 4 THEN 1 ELSE NULL END) AS 'PO',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 5 THEN 1 ELSE NULL END) AS 'LDG',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 6 THEN 1 ELSE NULL END) AS 'AB',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 7 THEN 1 ELSE NULL END) AS 'OD',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 8 THEN 1 ELSE NULL END) AS 'ODUT',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 9 THEN 1 ELSE NULL END) AS 'DEUC'
     FROM     sailor s
             LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
             -- LEFT JOIN bn_trade td ON s.BRANCHID = td.BRANCH_ID
             -- LEFT JOIN partii p ON td.TRADE_ID = p.TradeID
             LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
             LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
             LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
             LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
     WHERE  s.SAILORSTATUS = 1   AND dao.GROUP_ID IN (1,2,3,4,5,7)
     GROUP BY s.BRANCHID) a
WHERE  a.Branch IS NOT NULL
;



SELECT a.Branch, a.BRANCH_ID, sum(a.HLT) hlt,
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
       (sum(a.HLT1) + sum(a.HSLT1) + sum(a.MCPO1) + sum(a.SCPO1) + sum(a.CPO1) + sum(a.PO1) + sum(a.LDG1) + sum(a.AB1) + sum(a.OD1) + sum(a.ODUT1) + sum(a.DEUC1)) TotalNN,
       (a.HLT + a.HSLT + a.MCPO + a.SCPO + a.CPO + a.PO + a.LDG + a.AB + a.OD + a.ODUT + a.DEUC) Total
FROM (SELECT (SELECT b.BRANCH_NAME FROM  bn_branch b WHERE r.BRANCH_ID = b.BRANCH_ID) AS Branch,
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 11 THEN 1 ELSE NULL END) AS 'HLT', 0 'HLT1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 1 THEN 1 ELSE NULL END) AS 'HSLT', 0 'HSLT1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 2 THEN 1 ELSE NULL END) AS 'MCPO', 0 'MCPO1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 10 THEN 1 ELSE NULL END) AS 'SCPO', 0 'SCPO1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 3 THEN 1 ELSE NULL END) AS 'CPO', 0 'CPO1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 4 THEN 1 ELSE NULL END) AS 'PO', 0 'PO1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 5 THEN 1 ELSE NULL END) AS 'LDG', 0 'LDG1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 6 THEN 1 ELSE NULL END) AS 'AB', 0 'AB1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 7 THEN 1 ELSE NULL END) AS 'OD', 0 'OD1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 8 THEN 1 ELSE NULL END) AS 'ODUT', 0 'ODUT1',
              COUNT(CASE WHEN r.EQUIVALANT_RANKID = 9 THEN 1 ELSE NULL END) AS 'DEUC', 0 'DEUC1',
              r.BRANCH_ID
      FROM sailor s
      LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
       -- LEFT JOIN bn_trade td ON s.BRANCHID = td.BRANCH_ID
       -- LEFT JOIN partii p ON td.TRADE_ID = p.TradeID
       LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
       LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
       LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
       LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
       WHERE s.SAILORSTATUS = 1  AND dao.GROUP_ID IN (1,2,3,4,5,7)
       GROUP BY r.BRANCH_ID

       UNION

       SELECT (SELECT b.BRANCH_NAME FROM  bn_branch b WHERE  r.BRANCH_ID = b.BRANCH_ID) AS Branch,
              0 'HLT',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 11 THEN SanctionNo ELSE 0 END) AS 'HLT1', 0 'HSLT',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 1 THEN SanctionNo ELSE 0 END) AS 'HSLT1', 0 'MCPO',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 2 THEN SanctionNo ELSE 0 END) AS 'MCPO1', 0 'SCPO',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 10 THEN SanctionNo ELSE 0 END) AS 'SCPO1', 0 'CPO',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 3 THEN SanctionNo ELSE 0 END) AS 'CPO1', 0 'PO',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 4 THEN SanctionNo ELSE 0 END) AS 'PO1', 0 'LDG',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 5 THEN SanctionNo ELSE 0 END) AS 'LDG1', 0 'AB',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 6 THEN SanctionNo ELSE 0 END) AS 'AB1', 0 'OD',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 7 THEN SanctionNo ELSE 0 END) AS 'OD1', 0 'ODUT',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 8 THEN SanctionNo ELSE 0 END) AS 'ODUT1', 0 'DEUC',
             sum(CASE WHEN r.EQUIVALANT_RANKID = 9 THEN SanctionNo ELSE 0 END) AS 'DEUC1',
             r.BRANCH_ID
       FROM unitwisesanction s
       LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
       LEFT JOIN bn_branch b ON r.BRANCH_ID = b.BRANCH_ID
       LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
       LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
       LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
       WHERE UnitWiseSanctionID is not null
       GROUP BY r.BRANCH_ID) a
GROUP BY a.BRANCH_ID
;



select br.BRANCH_ID, br.BRANCH_NAME Branch, r.RANK_ID, r.RANK_NAME Rank, p.Name Part, sa.sanction sanc, b.Borne, sa.Remarks
from bn_rank r
left join (select us.RankID, us.PartIIID, sum(us.SanctionNo)sanction, us.Remarks from unitwisesanction us group by us.RankID,us.PartIIID) sa on r.RANK_ID = sa.RankID
left join (select s.RANKID, s.FIRSTPARTID, count(s.SAILORID)borne from sailor s where s.SAILORSTATUS = 1 group by s.RANKID,s.FIRSTPARTID) b on r.RANK_ID = b.RANKID
left join bn_branch br on r.BRANCH_ID = br.BRANCH_ID
left join partii p on p.PartIIID = b.FIRSTPARTID
left join bn_daogroup a on br.DAO_GROUPID = a.GROUP_ID
where -- r.ACTIVE_STATUS is not null
      -- AND a.GROUP_ID IN (1,2,3,4,5,7)
      -- and
      br.branch_id = 14 -- and borne is not null
group by b.rankid, sa.RankID, br.branch_id
order by r.BRANCH_ID, r.POSITION
;

select *
from unitwisesanction;


select br.BRANCH_ID, br.BRANCH_NAME Branch, r.RANK_ID, r.RANK_NAME Rank -- , p.Name Part, sa.sanction sanc, b.Borne, sa.Remarks
,(select sum(us.SanctionNo)sanction from unitwisesanction us where r.RANK_ID = us.RankID) sanc
-- ,(select us.Remarks from unitwisesanction us where r.RANK_ID = us.RankID) Remarks
,(select count(s.SAILORID)borne from sailor s where s.SAILORSTATUS = 1 and r.RANK_ID = s.RANKID) Borne
-- ,(select p.Name from partii p where ) Part
from bn_rank r
-- ,(select us.RankID, us.PartIIID, sum(us.SanctionNo)sanction, us.Remarks from unitwisesanction us group by us.RankID,us.PartIIID) sa
-- (select s.RANKID, s.FIRSTPARTID, count(s.SAILORID)borne from sailor s where s.SAILORSTATUS = 1 group by s.RANKID,s.FIRSTPARTID) b
,bn_branch br
-- , partii p
, bn_daogroup a
where r.branch_id=br.branch_id
-- and r.RANK_ID = sa.RankID
and br.branch_id = 1
and br.DAO_GROUPID = a.GROUP_ID
AND a.GROUP_ID IN (1,2,3,4,5,7)

;
/
where r.RANK_ID = sa.RankID
and r.RANK_ID = b.RANKID
and r.BRANCH_ID = br.BRANCH_ID
and p.PartIIID = b.FIRSTPARTID
and br.DAO_GROUPID = a.GROUP_ID
and br.branch_id = 14;

desc bn_daogroup;

select br.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, sum(sa.sanction) sanc, sum(b.Borne) bbb, sa.Remarks
    from bn_rank r
    left join (select us.RankID, us.PartIIID, sum(us.SanctionNo)sanction, us.Remarks from unitwisesanction us group by us.RankID,us.PartIIID) sa on r.RANK_ID = sa.RankID
    left join (select s.RANKID, s.FIRSTPARTID, count(s.SAILORID)borne from sailor s where s.SAILORSTATUS = 1 group by s.RANKID,s.FIRSTPARTID) b on r.RANK_ID = b.RANKID
    left join bn_branch br on r.BRANCH_ID = br.BRANCH_ID
    left join partii p on p.PartIIID = b.FIRSTPARTID
    left join bn_daogroup a on br.DAO_GROUPID = a.GROUP_ID
    where  r.ACTIVE_STATUS = 1
    AND a.GROUP_ID IN (1,2,3,4,5,7)
    and
    -- and r.branch_id=1
group by br.BRANCH_NAME, r.RANK_NAME, p.Name, sa.Remarks
order by r.BRANCH_ID, r.POSITION
;



#
select br.BRANCH_NAME, r.RANK_ID, r.RANK_NAME, p.PartIIID, p.Name PartIIName, b.borne
from bn_rank r
left join (select RANKID, FIRSTPARTID, count(SAILORID)borne from sailor where SAILORSTATUS = 1 group by RANKID, FIRSTPARTID) b on r.RANK_ID = b.RANKID
left join bn_branch br on r.BRANCH_ID = br.BRANCH_ID
left join partii p on p.PartIIID = b.FIRSTPARTID
order by r.BRANCH_ID, r.POSITION, p.PartIIID
;


select sum(us.SanctionNo)sanction
from unitwisesanction us
where us.RankID = 2 and us.PartIIID = 1
group by us.RankID,us.PartIIID;



## If one table is dependent on another table or like inner loop

SELECT us.RankID,us.PartIIID, SUM(us.SanctionNo)sanction
FROM unitwisesanction us
WHERE (us.RankID, us.PartIIID) IN (SELECT r.RANK_ID, p.PartIIID
                                   FROM bn_rank r
                                   LEFT JOIN (SELECT RANKID, FIRSTPARTID, COUNT(SAILORID)borne FROM sailor WHERE SAILORSTATUS = 1 GROUP BY RANKID, FIRSTPARTID) b ON r.RANK_ID = b.RANKID
                                   LEFT JOIN bn_branch br ON r.BRANCH_ID = br.BRANCH_ID
                                   LEFT JOIN partii p ON p.PartIIID = b.FIRSTPARTID
                                   ORDER BY r.BRANCH_ID, r.POSITION, p.PartIIID)
                                   GROUP BY us.RankID,us.PartIIID;

;


SELECT a.RankID, a.PartIIID, a.sanction, b.borne
FROM
       (SELECT SUM(us.SanctionNo)sanction, us.RankID, us.PartIIID
       FROM unitwisesanction us
       GROUP BY us.RankID,us.PartIIID) a,

       (SELECT r.RANK_ID, p.PartIIID, b.borne
       FROM bn_rank r
       LEFT JOIN (SELECT RANKID, FIRSTPARTID, COUNT(SAILORID)borne
       FROM sailor WHERE SAILORSTATUS = 1 GROUP BY RANKID, FIRSTPARTID) b ON r.RANK_ID = b.RANKID
       LEFT JOIN bn_branch br ON r.BRANCH_ID = br.BRANCH_ID
       LEFT JOIN partii p ON p.PartIIID = b.FIRSTPARTID
       ORDER BY r.BRANCH_ID, r.POSITION, p.PartIIID) b

WHERE a.RankID = b.RANK_ID
AND a.PartIIID = b.PartIIID


####################################
SELECT r.RANK_ID, p.PartIIID, b.borne,
(SELECT SUM(us.SanctionNo)sanction
FROM unitwisesanction us
WHERE us.RankID = r.RANK_ID
AND us.PartIIID = p.PartIIID
GROUP BY us.RankID,us.PartIIID) sanction,

(SELECT us.RankID
FROM unitwisesanction us
WHERE us.RankID = r.RANK_ID
AND us.PartIIID = p.PartIIID
GROUP BY us.RankID,us.PartIIID) RankID,

(SELECT us.PartIIID
FROM unitwisesanction us
WHERE us.RankID = r.RANK_ID
AND us.PartIIID = p.PartIIID
GROUP BY us.RankID,us.PartIIID) PartIIID


FROM bn_rank r
LEFT JOIN (SELECT RANKID, FIRSTPARTID, COUNT(SAILORID)borne
FROM sailor WHERE SAILORSTATUS = 1 GROUP BY RANKID, FIRSTPARTID) b ON r.RANK_ID = b.RANKID
LEFT JOIN bn_branch br ON r.BRANCH_ID = br.BRANCH_ID
left join bn_daogroup a on br.DAO_GROUPID = a.GROUP_ID
LEFT JOIN partii p ON p.PartIIID = b.FIRSTPARTID
where r.ACTIVE_STATUS = 1 -- AND s.ZONEID IN (4) AND s.ZONEID IN (4)
  AND a.GROUP_ID IN (1,2,3,4,5,7) -- order by r.BRANCH_ID, r.POSITION, p.PartIIID;
ORDER BY r.BRANCH_ID, r.POSITION, p.PartIIID;

## End If one table is dependent on another table or like inner loop



select br.BRANCH_NAME, r.RANK_ID, r.RANK_NAME, p.PartIIID, p.Name PartIIName, b.borne
from bn_rank r
left join (select RANKID, FIRSTPARTID, count(SAILORID)borne from sailor where SAILORSTATUS = 1 group by RANKID, FIRSTPARTID) b on r.RANK_ID = b.RANKID
left join bn_branch br on r.BRANCH_ID = br.BRANCH_ID
left join partii p on p.PartIIID = b.FIRSTPARTID
left join bn_daogroup a on br.DAO_GROUPID = a.GROUP_ID
where  r.ACTIVE_STATUS = 1   AND a.GROUP_ID IN (1,2,3,4,5,7) and br.branch_id=1
order by r.BRANCH_ID, r.POSITION, p.PartIIID;

select sum(us.SanctionNo)sanction
from unitwisesanction us
where us.RankID = 2 and us.PartIIID = 1
group by us.RankID,us.PartIIID;



####################################
select br.BRANCH_NAME Branch, r.RANK_ID, r.RANK_NAME Rank, p.PartIIID, p.Name Part, b.Borne,
       (SELECT SUM(us.SanctionNo)sanction
       FROM unitwisesanction us
       WHERE us.RankID = r.RANK_ID
       AND us.PartIIID = p.PartIIID
       GROUP BY us.RankID,us.PartIIID) sanction
from bn_rank r
left join (select SAILORID,RANKID, FIRSTPARTID, count(SAILORID)borne from sailor where SAILORSTATUS = 1 group by RANKID, FIRSTPARTID) b on r.RANK_ID = b.RANKID
left join bn_branch br on r.BRANCH_ID = br.BRANCH_ID
left join partii p on p.PartIIID = b.FIRSTPARTID
left join bn_daogroup a on br.DAO_GROUPID = a.GROUP_ID
left join sailor s on s.SAILORID = b.SAILORID
where r.ACTIVE_STATUS = 1 $sql $daoGroup
order by r.BRANCH_ID, r.POSITION, p.PartIIID;


select br.BRANCH_NAME Branch, r.RANK_ID, r.RANK_NAME Rank, p.PartIIID, p.Name Part, b.Borne,
    (SELECT SUM(us.SanctionNo)sanction
    FROM unitwisesanction us
    WHERE us.RankID = r.RANK_ID
    AND us.PartIIID = p.PartIIID
    GROUP BY us.RankID,us.PartIIID) sanction
from bn_rank r
left join (select RANKID, FIRSTPARTID, count(SAILORID)borne from sailor where SAILORSTATUS = 1 group by RANKID, FIRSTPARTID) b on r.RANK_ID = b.RANKID
left join bn_branch br on r.BRANCH_ID = br.BRANCH_ID
left join sailor s on s.RANKID = r.RANK_ID
left join partii p on p.PartIIID = s.FIRSTPARTID
left join bn_daogroup a on br.DAO_GROUPID = a.GROUP_ID
where r.ACTIVE_STATUS = 1
AND s.ZONEID IN (1)
AND a.GROUP_ID IN (1,2,3,4,5,7)
group by r.RANK_ID, p.PartIIID, s.RANKID
order by r.BRANCH_ID, r.POSITION, p.PartIIID
;


### done by nurulla bhai

select b.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, count(SAILORID)Borne,
       (SELECT SUM(us.SanctionNo)sanction FROM unitwisesanction us  WHERE us.RankID = s.RANKID
       AND us.PartIIID = s.FIRSTPARTID GROUP BY us.RankID,us.PartIIID) sanction
from sailor s
left join bn_branch b on s.BRANCHID = b.BRANCH_ID
left join bn_rank r on s.RANKID = r.RANK_ID
left join partii p on s.FIRSTPARTID = p.PartIIID
left join bn_daogroup a on b.DAO_GROUPID = a.GROUP_ID
where SAILORSTATUS = 1 AND a.GROUP_ID IN (1,2,3,4,5,7)
group by RANKID, FIRSTPARTID
order by b.BRANCH_ID, r.POSITION, p.PartIIID

### done by nurullah bhai
select sh.NAME ShipName, pu.NAME PostingName, b.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, count(SAILORID)Borne,

(SELECT SUM(us.SanctionNo)sanction FROM unitwisesanction us WHERE us.RankID = s.RANKID AND us.PostingUnitID = s.POSTINGUNITID
AND us.PartIIID = s.FIRSTPARTID GROUP BY us.PostingUnitID,us.RankID,us.PartIIID) sanction,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and t.PostingUnitID = s.POSTINGUNITID )TotalIn,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and ts.POSTINGUNITID = s.POSTINGUNITID )TotalOut

from sailor s
left join bn_branch b on s.BRANCHID = b.BRANCH_ID
left join bn_rank r on s.RANKID = r.RANK_ID
left join partii p on s.FIRSTPARTID = p.PartIIID
left join bn_daogroup a on b.DAO_GROUPID = a.GROUP_ID
left join bn_ship_establishment sh on s.SHIPESTABLISHMENTID = sh.SHIP_ESTABLISHMENTID
left join bn_posting_unit pu on s.POSTINGUNITID = pu.POSTING_UNITID
where SAILORSTATUS = 1 -- $sql $daoGroup
and s.POSTINGUNITID = 1
and s.BRANCHID = 1
group by s.POSTINGUNITID, s.RANKID, s.FIRSTPARTID
limit 100;


select sh.NAME ShipName, sh.ZONE_ID, pu.NAME PostingName, b.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, count(SAILORID)Borne,

(SELECT SUM(us.SanctionNo)sanction FROM unitwisesanction us WHERE us.RankID = s.RANKID AND us.PostingUnitID = s.POSTINGUNITID
AND us.PartIIID = s.FIRSTPARTID GROUP BY us.PostingUnitID,us.RankID,us.PartIIID) sanction,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and t.PostingUnitID = s.POSTINGUNITID )TotalIn,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and ts.POSTINGUNITID = s.POSTINGUNITID )TotalOut

from sailor s
left join bn_branch b on s.BRANCHID = b.BRANCH_ID
left join bn_rank r on s.RANKID = r.RANK_ID
left join partii p on s.FIRSTPARTID = p.PartIIID
left join bn_daogroup a on b.DAO_GROUPID = a.GROUP_ID
left join bn_ship_establishment sh on s.SHIPESTABLISHMENTID = sh.SHIP_ESTABLISHMENTID
-- left join bn_navyadminhierarchy bnh on sh.ZONE_ID = bnh.PARENT_ID
left join bn_posting_unit pu on s.POSTINGUNITID = pu.POSTING_UNITID
where SAILORSTATUS = 1 AND s.ZONEID IN (1) AND s.AREAID IN (5) AND s.EQUIVALANTRANKID IN (1) AND a.GROUP_ID IN (1,2,3,4,5,7)
group by s.POSTINGUNITID, s.RANKID, s.BRANCHID
-- limit 50


select *, ADMIN_ID, PARENT_ID
from bn_navyadminhierarchy where ADMIN_TYPE = 2; #1 means zone, 2 means area


SELECT a.NAME AREA_NAME, a.ADMIN_ID, a.PARENT_ID, z.NAME ZONE_NAME
FROM bn_navyadminhierarchy a
LEFT JOIN (SELECT * FROM bn_navyadminhierarchy WHERE ADMIN_TYPE = 1 AND ACTIVE_STATUS = 1 ORDER BY CAST(CODE AS SIGNED) ASC) z on a.PARENT_ID = z.ADMIN_ID
WHERE a.ADMIN_TYPE = 2
AND a.ACTIVE_STATUS = 1
ORDER BY a.PARENT_ID;


select *
from sailor where AREAID != 5;

select *
from bn_ship_establishment where AREA_ID



select sh.NAME ShipName,sh.AREA_ID, pu.NAME PostingName, b.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, count(SAILORID)Borne,

(SELECT SUM(us.SanctionNo)sanction FROM unitwisesanction us WHERE us.RankID = s.RANKID AND us.PostingUnitID = s.POSTINGUNITID
AND us.PartIIID = s.FIRSTPARTID GROUP BY us.PostingUnitID,us.RankID,us.PartIIID) sanction,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and t.PostingUnitID = s.POSTINGUNITID )TotalIn,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and ts.POSTINGUNITID = s.POSTINGUNITID )TotalOut

from sailor s
left join bn_branch b on s.BRANCHID = b.BRANCH_ID
left join bn_rank r on s.RANKID = r.RANK_ID
left join partii p on s.FIRSTPARTID = p.PartIIID
left join bn_daogroup a on b.DAO_GROUPID = a.GROUP_ID
left join bn_ship_establishment sh on s.SHIPESTABLISHMENTID = sh.SHIP_ESTABLISHMENTID
left join bn_posting_unit pu on s.POSTINGUNITID = pu.POSTING_UNITID
where SAILORSTATUS = 1  AND s.ZONEID IN (1)  AND a.GROUP_ID IN (1,2,3,4,5,7)
group by s.POSTINGUNITID, s.RANKID, s.BRANCHID



select sh.NAME ShipName, pu.NAME PostingName, b.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, count(SAILORID)Borne,
(SELECT SUM(us.SanctionNo)sanction FROM unitwisesanction us WHERE us.RankID = s.RANKID AND us.PostingUnitID = s.POSTINGUNITID
AND us.PartIIID = s.FIRSTPARTID GROUP BY us.PostingUnitID,us.RankID,us.PartIIID) sanction,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and t.PostingUnitID = s.POSTINGUNITID )TotalIn,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and ts.POSTINGUNITID = s.POSTINGUNITID )TotalOut

from sailor s
left join bn_branch b on s.BRANCHID = b.BRANCH_ID
left join bn_rank r on s.RANKID = r.RANK_ID
left join partii p on s.FIRSTPARTID = p.PartIIID
left join bn_daogroup a on b.DAO_GROUPID = a.GROUP_ID
left join bn_ship_establishment sh on s.SHIPESTABLISHMENTID = sh.SHIP_ESTABLISHMENTID
left join bn_posting_unit pu on s.POSTINGUNITID = pu.POSTING_UNITID
where SAILORSTATUS = 1 -- $sql $daoGroup
and s.zoneid = 1
and s.areaId = 5
      and s.POSTINGUNITID = 216
and s.BRANCHID = 1
group by s.POSTINGUNITID, RANKID, FIRSTPARTID



;



select sh.NAME ShipName,sh.AREA_ID, pu.NAME PostingName, b.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, count(SAILORID)Borne,

(SELECT SUM(us.SanctionNo)sanction FROM unitwisesanction us WHERE us.RankID = s.RANKID AND us.PostingUnitID = s.POSTINGUNITID
AND us.PartIIID = s.FIRSTPARTID GROUP BY us.PostingUnitID,us.RankID,us.PartIIID) sanction,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and t.PostingUnitID = s.POSTINGUNITID )TotalIn,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and ts.POSTINGUNITID = s.POSTINGUNITID )TotalOut

from sailor s
left join bn_branch b on s.BRANCHID = b.BRANCH_ID
left join bn_rank r on s.RANKID = r.RANK_ID
left join partii p on s.FIRSTPARTID = p.PartIIID
left join bn_daogroup a on b.DAO_GROUPID = a.GROUP_ID
left join bn_ship_establishment sh on s.SHIPESTABLISHMENTID = sh.SHIP_ESTABLISHMENTID
left join bn_posting_unit pu on s.POSTINGUNITID = pu.POSTING_UNITID
where SAILORSTATUS = 1
AND a.GROUP_ID IN (1,2,3,4,5,7)

AND s.ZONEID IN (1) AND s.AREAID IN (5)
AND s.POSTINGUNITID IN (216)
AND s.BRANCHID = 1
group by s.POSTINGUNITID, s.RANKID, s.FIRSTPARTID



SELECT DISTINCT s.OFFICIALNUMBER AS O_No , s.FULLNAME AS Name , r.RANK_NAME AS Rank,
                (SELECT CASE ass.CharacterType WHEN 0 THEN 'VG' WHEN 1 THEN 'VG_' WHEN 2 THEN 'GOOD' WHEN 3 THEN 'FAIR' WHEN 4 THEN 'INDIF' WHEN 5 THEN 'BAD' ELSE NULL END) AS CHAR2009,
                (SELECT CASE ass.EfficiencyType WHEN 0 THEN 'SUPER' WHEN 1 THEN 'SAT' WHEN 2 THEN 'MOD' WHEN 3 THEN 'INFER' WHEN 4 THEN 'UT' ELSE NULL END) AS Eff,
                bpu.NAME AS posting_unit , s.SAILORID
FROM sailor s
LEFT JOIN assessment ass ON s.SAILORID = ass.SailorID
LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
LEFT JOIN bn_trade td ON s.BRANCHID = td.BRANCH_ID
left join bn_branch br on br.BRANCH_ID =s.BRANCHID
left join postingunit b on b.PostingUnitID = s.POSTINGUNITID
LEFT JOIN bn_daogroup dao ON dao.GROUP_ID = br.DAO_GROUPID
LEFT JOIN partii p ON td.TRADE_ID = p.TradeID WHERE s.SAILORSTATUS=1 and ass.AssessYear in ('2018') AND dao.GROUP_ID IN (1,2,3,4,5,7) AND b.OrganizationID NOT IN (63)


select *
from bn_branch;

select *, POSTINGUNITID
from sailor;

select *, OrganizationID, PostingUnitID
from postingunit;



select m.SAILORID, m.OFFICIALNUMBER, m.FULLNAME, r.RANK_NAME, p.NAME posting_unit
from
(select SAILORID, OFFICIALNUMBER, FULLNAME, RANKID, FIRSTPARTID, POSTINGUNITID, BRANCHID, AREAID, ZONEID
from sailor
where SAILORSTATUS = 1
and SAILORID not in (select SailorID from assessment where AssessYear = 2018))m
left join bn_rank r on m.RANKID = r.RANK_ID
left join bn_branch br on br.BRANCH_ID = m.BRANCHID
LEFT JOIN bn_posting_unit p ON m.POSTINGUNITID = p.POSTING_UNITID
left join partii par on m.FIRSTPARTID = par.PartIIID
LEFT JOIN bn_trade t on t.TRADE_ID = par.TradeID
LEFT JOIN bn_daogroup dao ON dao.GROUP_ID = br.DAO_GROUPID
;

select a.SailorID, c.LOOKUP_DATA_NAME CharacterName, e.LOOKUP_DATA_NAME EfficiencyName
from assessment a
left join sa_lookup_data c on a.CharacterType = c.ORDER_SL_NO and c.LOOKUP_GRP_ID = 12
left join sa_lookup_data e on a.EfficiencyType = e.ORDER_SL_NO and e.LOOKUP_GRP_ID = 13
where a.SailorID = 23123 and a.AssessYear = 2017


select a.SailorID, group_concat(c.LOOKUP_DATA_NAME) CharacterName, group_concat(e.LOOKUP_DATA_NAME) EfficiencyName
from assessment a
left join sa_lookup_data c on a.CharacterType = c.ORDER_SL_NO and c.LOOKUP_GRP_ID = 12
left join sa_lookup_data e on a.EfficiencyType = e.ORDER_SL_NO and e.LOOKUP_GRP_ID = 13
where a.SailorID = 23123 and a.AssessYear IN (2017,2016) order by a.AssessYear


SELECT DISTINCT s.OFFICIALNUMBER AS O_No , s.FULLNAME AS Name, r.RANK_NAME AS Rank, bpu.NAME AS posting_unit , s.SAILORID
FROM sailor s
left join bn_rank r on r.RANK_ID = s.RANKID
LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
LEFT JOIN transfer t ON s.SAILORID = t.SailorID
LEFT JOIN partii pa2 on pa2.PartIIID = s.FIRSTPARTID
where s.SAILORSTATUS=1
AND dao.GROUP_ID IN (1,2,3,4,5,7)
AND p.ORG_ID IN (63) and not exists (select 1 FROM sailor m left join assessment ass on ass.SailorID = m.SAILORID where AssessYear = '2018' and m.SAILORID = s.SAILORID )

# stable
SELECT DISTINCT s.OFFICIALNUMBER AS O_No , s.FULLNAME AS Name, r.RANK_NAME AS Rank, bpu.NAME AS posting_unit , s.SAILORID
FROM sailor s
left join bn_rank r on r.RANK_ID = s.RANKID
LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
LEFT JOIN transfer t ON s.SAILORID = t.SailorID
LEFT JOIN partii pa2 on pa2.PartIIID = s.FIRSTPARTID
where s.SAILORSTATUS=1
AND dao.GROUP_ID IN (1,2,3,4,5,7)
and not exists (select 1 FROM assessment asses where AssessYear = '2018' and asses.SailorID = s.SAILORID)


# stable

select s.SAILORID, s.OFFICIALNUMBER, s.FULLNAME,
      CASE
        WHEN s.MAXGCB = 1 THEN '1st'
        WHEN s.MAXGCB = 2 THEN '2nd'
        WHEN s.MAXGCB = 3 THEN '3rd'
      ELSE ''
END MAXGCB,
(CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) Rank,
s.NavyId, s.IsMLR,date_format(s.ENTRYDATE, '%d-%m-%Y')JOINING_DATE, s.MOBILE, s.REMARKS
from sailor s
left join bn_rank r on s.RANKID = r.RANK_ID
left join partii p on s.FIRSTPARTID = p.PartIIID
LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
where s.SAILORSTATUS = 1
ORDER BY s.BRANCHID, r.POSITION, s.OFFICIALNUMBER ASC


# stable

select s.SAILORID, s.OFFICIALNUMBER, s.FULLNAME, m.MedicalCategoryName,
(CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) Rank,
pft.RunningWalk, pft.PushUp, pft.ReachUp, pft.ShuttleRun, pft.Swimming, pft.Remarks
from sailor s
left join bn_rank r on s.RANKID = r.RANK_ID
left join partii p on s.FIRSTPARTID = p.PartIIID
LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
left join medicalcategory m on m.MedicalCategoryID = s.MEDICALCATEGORY
left join (select * from (select * from pfttran order by SailorID, PftID desc)m group by SailorID)pft on s.SAILORID = pft.SailorID
where s.SAILORSTATUS = 1
ORDER BY s.BRANCHID, r.POSITION, s.OFFICIALNUMBER ASC

# stable
select m.MovementID, m.SailorID, a.NAME Appoinment, sh.SHORT_NAME, p.NAME Posting,
DATE_FORMAT(m.DraftInDate, '%d-%m-%Y')DraftInDate, DATE_FORMAT(m.DraftOutDate, '%d-%m-%Y')DraftOutDate, c.FULL_NAME, u.FULL_NAME, DATE_FORMAT(m.CRE_DT, '%d-%m-%Y')CRE_DT, DATE_FORMAT(m.UPD_DT, '%d-%m-%Y')UPD_DT
from movement m
left join bn_appointmenttype a on m.AppointmentTypeID = a.APPOINT_TYPEID
left join bn_ship_establishment sh on sh.SHIP_ESTABLISHMENTID = m.ShipEstablishmentID
left join bn_posting_unit p on m.PostingUnitID = p.POSTING_UNITID
left join sa_users c on c.USER_ID = m.CRE_BY
left join sa_users u on u.USER_ID = m.UPD_BY
where m.SailorID = 20050149
order by m.DraftInDate, m.DraftOutDate;







select sh.NAME ShipName,sh.AREA_ID, pu.NAME PostingName, b.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, count(SAILORID)Borne,

(SELECT SUM(us.SanctionNo)sanction FROM unitwisesanction us WHERE us.RankID = s.RANKID AND us.PostingUnitID = s.POSTINGUNITID
AND us.PartIIID = s.FIRSTPARTID GROUP BY us.PostingUnitID,us.RankID,us.PartIIID) sanction,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and t.PostingUnitID = s.POSTINGUNITID )TotalIn,

(select count(t.TransferID)TotalOut from transfer t left join sailor ts on t.SailorID = ts.SAILORID where ts.RANKID = s.RANKID
and ts.FIRSTPARTID = s.FIRSTPARTID and ts.POSTINGUNITID = s.POSTINGUNITID )TotalOut

from sailor s
left join bn_branch b on s.BRANCHID = b.BRANCH_ID
left join bn_rank r on s.RANKID = r.RANK_ID
left join partii p on s.FIRSTPARTID = p.PartIIID
left join bn_daogroup a on b.DAO_GROUPID = a.GROUP_ID
left join bn_ship_establishment sh on s.SHIPESTABLISHMENTID = sh.SHIP_ESTABLISHMENTID
left join bn_posting_unit pu on s.POSTINGUNITID = pu.POSTING_UNITID
where SAILORSTATUS = 1  AND s.ZONEID IN (1) AND s.SHIPESTABLISHMENTID IN (53)  AND a.GROUP_ID IN (1,2,3,4,5,7)
group by s.POSTINGUNITID, RANKID, FIRSTPARTID




SELECT ShipName, AREA_ID, PostingName,Branch, Rank, Part,
SUM(Borne) Borne, SUM(sanction) sanction, SUM(TotalIn) TotalIn, SUM(TotalOut) TotalOut
FROM
(SELECT sh.NAME ShipName,sh.AREA_ID, pu.NAME PostingName, b.BRANCH_NAME Branch, r.RANK_NAME Rank, p.Name Part, COUNT(SAILORID)Borne,

(SELECT SUM(us.SanctionNo)sanction FROM unitwisesanction us WHERE us.RankID = s.RANKID AND us.PostingUnitID = s.POSTINGUNITID
AND us.PartIIID = s.FIRSTPARTID GROUP BY us.PostingUnitID,us.RankID,us.PartIIID) sanction,

(SELECT COUNT(t.TransferID)TotalOut FROM transfer t LEFT JOIN sailor ts ON t.SailorID = ts.SAILORID WHERE ts.RANKID = s.RANKID
AND ts.FIRSTPARTID = s.FIRSTPARTID AND t.PostingUnitID = s.POSTINGUNITID )TotalIn,

(SELECT COUNT(t.TransferID)TotalOut FROM transfer t LEFT JOIN sailor ts ON t.SailorID = ts.SAILORID WHERE ts.RANKID = s.RANKID
AND ts.FIRSTPARTID = s.FIRSTPARTID AND ts.POSTINGUNITID = s.POSTINGUNITID )TotalOut

FROM sailor s
LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
LEFT JOIN partii p ON s.FIRSTPARTID = p.PartIIID
LEFT JOIN bn_daogroup a ON b.DAO_GROUPID = a.GROUP_ID
LEFT JOIN bn_ship_establishment sh ON s.SHIPESTABLISHMENTID = sh.SHIP_ESTABLISHMENTID
LEFT JOIN bn_posting_unit pu ON s.POSTINGUNITID = pu.POSTING_UNITID
WHERE SAILORSTATUS = 1 AND s.ZONEID IN (1) AND s.SHIPESTABLISHMENTID IN (53) AND a.GROUP_ID IN (1,2,3,4,5,7)
GROUP BY s.POSTINGUNITID, RANKID, FIRSTPARTID) a
GROUP BY ShipName, AREA_ID, PostingName, Branch,Rank, Part WITH ROLLUP


#--------------------------------------------------Stable--------------------------------------------------
-- SELECT K.ShipName, K.AREA_ID, K.PostingName,K.Branch, K.RANK_NAME, K.Part, sum(K.Borne) Borne, sum(K.sanction)sanction, sum(K.TotalIn) TotalIn, sum(K.TotalOut) TotalOut
SELECT coalesce(K.ShipName,'Grand Total')ShipName, K.AREA_ID, coalesce(K.PostingName,'Ship Total')PostingName, coalesce(K.Branch,'Unit Total')Branch, coalesce(K.RANK_NAME,'Branch Total')RANK_NAME , K.Part, ifnull(sum(K.Borne),0)Borne, ifnull(sum(K.sanction),0)sanction, sum(K.TotalIn)TotalIn, sum(K.TotalOut)TotalOut
FROM (
      SELECT ShipName, AREA_ID, PostingName,Branch, RANK_NAME, ifnull(Part,'') Part, Borne, sanction, TotalIn, TotalOut
      FROM (
            SELECT sh.NAME ShipName,sh.AREA_ID, pu.NAME PostingName, b.BRANCH_NAME Branch, r.RANK_NAME , p.Name Part, COUNT(SAILORID)Borne,
            (SELECT SUM(us.SanctionNo)sanction FROM unitwisesanction us WHERE us.RankID = s.RANKID AND us.PostingUnitID = s.POSTINGUNITID
            AND us.PartIIID = s.FIRSTPARTID GROUP BY us.PostingUnitID,us.RankID,us.PartIIID) sanction,

            (SELECT COUNT(t.TransferID)TotalOut FROM transfer t LEFT JOIN sailor ts ON t.SailorID = ts.SAILORID WHERE ts.RANKID = s.RANKID
            AND ts.FIRSTPARTID = s.FIRSTPARTID AND t.PostingUnitID = s.POSTINGUNITID )TotalIn,

            (SELECT COUNT(t.TransferID)TotalOut FROM transfer t LEFT JOIN sailor ts ON t.SailorID = ts.SAILORID WHERE ts.RANKID = s.RANKID
            AND ts.FIRSTPARTID = s.FIRSTPARTID AND ts.POSTINGUNITID = s.POSTINGUNITID )TotalOut

            FROM sailor s
            LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
            LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
            LEFT JOIN partii p ON s.FIRSTPARTID = p.PartIIID
            LEFT JOIN bn_daogroup a ON b.DAO_GROUPID = a.GROUP_ID
            LEFT JOIN bn_ship_establishment sh ON s.SHIPESTABLISHMENTID = sh.SHIP_ESTABLISHMENTID
            LEFT JOIN bn_posting_unit pu ON s.POSTINGUNITID = pu.POSTING_UNITID
            WHERE SAILORSTATUS = 1 AND s.ZONEID IN (1) AND s.SHIPESTABLISHMENTID IN (53,125) AND a.GROUP_ID IN (1,2,3,4,5,7)
            GROUP BY s.POSTINGUNITID, RANKID, FIRSTPARTID) a
  ) K
GROUP BY ShipName, PostingName, Branch, RANK_NAME, Part WITH ROLLUP
HAVING Part IS NOT NULL OR RANK_NAME IS NULL
;



#--------------------------------------------------Stable--------------------------------------------------
SELECT
    (SELECT FULL_NAME FROM sa_users WHERE USER_ID = a.CRE_BY) CRE_BY, s.OFFICIALNUMBER O_NO,
    a.TranField, COUNT(a.CRE_BY)TotalEntry, DATE_FORMAT(a.CRE_DT,'%d-%m-%Y')CRE_DT, DATE_FORMAT(a.CRE_DT,'%H:%i')CRE_TM,
    (SELECT FULL_NAME FROM sa_users WHERE USER_ID = a.UPD_BY) UPD_BY, COUNT(UPD_BY)TotUpd, DATE_FORMAT(a.UPD_DT,'%d-%m-%Y')UPD_DT,
    DATE_FORMAT(a.UPD_DT,'%H:%i')UPD_TM
FROM
    (
    SELECT CRE_BY, 'Exam/Test Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM examtran
    UNION
    SELECT CRE_BY, 'Training/Course' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM coursetran
    UNION
    SELECT CRE_BY, 'Leave Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM `leave`
    UNION
    SELECT CRE_BY, 'Re-Engagement Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM engagement
    UNION
    SELECT CRE_BY, 'Medical Category Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM medical
    UNION
    SELECT CRE_BY, 'Transfer Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM transfer
    UNION
    SELECT CRE_BY, 'Movement History' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM movement
    UNION
    SELECT CRE_BY, 'Temporary Movement Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM movementtemp
    UNION
    SELECT CRE_BY, 'GCB Award/Restore' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM gcb
    UNION
    SELECT CRE_BY, 'Marriage Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM marriage
    UNION
    SELECT CRE_BY, 'Children Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM children
    UNION
    SELECT CRE_BY, 'Academic Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM academic
    UNION
    SELECT CRE_BY, 'PFT Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM pfttran
    UNION
    SELECT CRE_BY, 'Medal Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM medaltran
    UNION
    SELECT CRE_BY, 'Honor Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM honortran
    UNION
    SELECT CRE_BY, 'Jesthata Padak Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM jesthatapadaktran
    UNION
    SELECT CRE_BY, 'Punishment Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM punishment
    UNION
    SELECT CRE_BY, 'Mark Run/Absent Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM markrun # End Regular Transaction
    UNION
    SELECT CRE_BY, 'Assessment Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM assessment
    UNION
    SELECT CRE_BY, 'Language Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM languagetran
    UNION
    SELECT CRE_BY, 'Sailors Opinion Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM willingnotwilling
    UNION
    SELECT CRE_BY, 'Fraudulent Entry Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM fraudulentinfo
    UNION
    SELECT CRE_BY, 'Specialization Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM spectran
    UNION
    SELECT CRE_BY, 'Security Clearance Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM clearanceinfo
    UNION
    SELECT CRE_BY, 'Nominee Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM nominee
    UNION
    SELECT CRE_BY, 'Navy ID Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM navyid
    UNION
    SELECT CRE_BY, 'MLR Info' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM mlr
    UNION
    SELECT CRE_BY, 'DAO Amendments' TranField, CRE_DT, UPD_BY, UPD_DT, SailorID
    FROM daoamend
    ) a
left join sailor s on s.SAILORID = a.SailorID
WHERE ((CAST(a.CRE_DT AS DATE) BETWEEN '$from_date' AND '$to_date') OR (CAST(a.UPD_DT AS DATE) BETWEEN '$from_date' AND '$to_date')) AND (a.CRE_BY IN ($userIdStr) OR a.UPD_BY IN ($userIdStr))
GROUP BY a.CRE_BY, s.OFFICIALNUMBER, a.UPD_BY













