--Tables 
CREATE TABLE states (
  id int(11) NOT NULL primary key auto_increment,
  country_id int(11) NOT NULL,
  state_name varchar(30) NOT NULL,
  foreign key(country_id) references countries(country_id)
)

CREATE TABLE countries (
  country_id int(11) NOT NULL primary key auto_increment,
  country_name varchar(30) NOT NULL
)

--Inner Join
SELECT * from countries INNER JOIN states on states.country_id=countries.country_id
--Left Join
SELECT * from countries LEFT JOIN states on states.country_id=countries.country_id
--Right Join
SELECT * from countries RIGHT JOIN states on states.country_id=countries.country_id


-- 89 Joining Syntax:
select br.BRANCH_ID, br.BRANCH_NAME Branch, r.RANK_ID, r.RANK_NAME Rank, p.Name Part, sa.sanction sanc, b.Borne, sa.Remarks
,(select sum(us.SanctionNo)sanction from unitwisesanction us where r.RANK_ID = us.RankID) sanc
,(select us.Remarks from unitwisesanction us where r.RANK_ID = us.RankID) Remarks
,(select count(s.SAILORID)borne from sailor s where s.SAILORSTATUS = 1 and r.RANK_ID = s.RANKID) Borne
,(select p.Name from partii p where) Part
from bn_rank r
,(select us.RankID, us.PartIIID, sum(us.SanctionNo)sanction, us.Remarks from unitwisesanction us group by us.RankID,us.PartIIID) sa
,(select s.RANKID, s.FIRSTPARTID, count(s.SAILORID)borne from sailor s where s.SAILORSTATUS = 1 group by s.RANKID,s.FIRSTPARTID) b
,bn_branch br
,partii p
,bn_daogroup a
where r.branch_id=br.branch_id
and r.RANK_ID = sa.RankID
and br.branch_id = 14
and br.DAO_GROUPID = a.GROUP_ID
AND a.GROUP_ID IN (1,2,3,4,5,7)
;
