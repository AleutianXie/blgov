--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.16
-- Dumped by pg_dump version 9.6.16

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: userid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.userid_seq
    START WITH 500001
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.userid_seq OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: adminInfoTable; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."adminInfoTable" (
    "userID" integer DEFAULT nextval('public.userid_seq'::regclass) NOT NULL,
    "Account" character varying(50),
    "Password" character varying(120),
    "Name" character varying(50),
    "PhoneNumber" character varying(50),
    "UserType" integer,
    "Token" character varying(500),
    "Status" integer,
    "IsHire" smallint DEFAULT 1,
    "HirerName" character varying(64),
    "HirerPhone" character varying(32),
    "CreaterAt" timestamp without time zone,
    "GovUnitName" character varying(100),
    "TownID" integer
);


ALTER TABLE public."adminInfoTable" OWNER TO postgres;

--
-- Name: TABLE "adminInfoTable"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public."adminInfoTable" IS '用户信息表';


--
-- Name: conditionid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.conditionid_seq
    START WITH 400001
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.conditionid_seq OWNER TO postgres;

--
-- Name: conditionInfoTable; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."conditionInfoTable" (
    "ConditionID" integer DEFAULT nextval('public.conditionid_seq'::regclass) NOT NULL,
    "EmployeeID" integer,
    "RecordingTime" date,
    "ObservationDay" integer,
    "Temperature" numeric(8,2),
    "MeasuringTime" time without time zone,
    "Symptom" character varying(100),
    "SymptomDesc" text
);


ALTER TABLE public."conditionInfoTable" OWNER TO postgres;

--
-- Name: TABLE "conditionInfoTable"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public."conditionInfoTable" IS '健康状况信息表';


--
-- Name: departmentid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.departmentid_seq
    START WITH 200001
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.departmentid_seq OWNER TO postgres;

--
-- Name: departmentInfoTable; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."departmentInfoTable" (
    "DepartmentID" integer DEFAULT nextval('public.departmentid_seq'::regclass) NOT NULL,
    "EnterpriseID" integer NOT NULL,
    "DepartmentName" character varying(100),
    "DepartmentContacts" character varying(50),
    "PhoneNumber" character varying(50),
    "PreventionDesc" text,
    "DepartmentDesc" text,
    created_at timestamp without time zone
);


ALTER TABLE public."departmentInfoTable" OWNER TO postgres;

--
-- Name: employeeid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.employeeid_seq
    START WITH 300001
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.employeeid_seq OWNER TO postgres;

--
-- Name: employeeInfoTable; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."employeeInfoTable" (
    "EmployeeID" integer DEFAULT nextval('public.employeeid_seq'::regclass) NOT NULL,
    "EnterpriseID" integer,
    "DepartmentID" integer,
    "Name" character varying(50),
    "PhoneNumber" character varying(50),
    "Gender" integer,
    "Province" character varying(100),
    "City" character varying(100),
    "District" character varying(100),
    "Street" character varying(100),
    "Address" character varying(500),
    "OutgoingDesc" text,
    "ContactSituation" integer,
    "LastContactDate" date,
    "ContactDesc" text,
    "OwnerHealth" character varying(100),
    "OwnerHealthDesc" text,
    "RelativesHealth" character varying(100),
    "RelativesHealthDesc" text,
    "OtherPpersonnelHealth" character varying(100),
    "OtherPpersonnelHealthDesc" text,
    "IsMedicalObservation" integer,
    "MedicalObservationDesc" text,
    "MedicalObservationStartDate" date,
    "MedicalObservationEndDate" date,
    "MedicalObservationAddress" bit varying(500)[],
    "Account" character varying(50),
    "Password" character varying(50),
    "Token" character varying(500),
    "IsHire" smallint DEFAULT 1,
    "HirerName" character varying(32),
    "HirerPhone" character varying(32),
    created_at timestamp without time zone,
    "OutgoingSituation" smallint,
    "OwnerStatus" integer,
    "IdCardNumber" character varying(50),
    "DeparturePlace" character varying(500),
    "ReturnTraffic" character varying(500),
    "WorkTraffic" integer,
    "IsLeaveNingbo" integer,
    "IsFever" integer,
    "Desc" text,
    "ReturnNingBoDate" text
);


ALTER TABLE public."employeeInfoTable" OWNER TO postgres;

--
-- Name: TABLE "employeeInfoTable"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public."employeeInfoTable" IS 'employeeInfoTable';


--
-- Name: enterpriseid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.enterpriseid_seq
    START WITH 100001
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.enterpriseid_seq OWNER TO postgres;

--
-- Name: enterpriseInfoTable; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."enterpriseInfoTable" (
    "EnterpriseID" integer DEFAULT nextval('public.enterpriseid_seq'::regclass) NOT NULL,
    "EnterpriseName" character varying(500),
    "District" character varying(500),
    "Address" character varying(500),
    "StartDate" date,
    "Contacts" character varying(50),
    "PhoneNumber" character varying(50),
    "PreventionDesc" text,
    "EnterpriseScale" integer,
    "EmployeesNumber" integer,
    "Account" character varying(50),
    "Password" character varying(50),
    "Token" character varying(500),
    "BackEmpNumber" integer,
    "ProductingPlan" character varying(500),
    "TownID" integer,
    "Industry" character varying(500),
    "IndustryTableID" integer,
    "OrganizationCode" character varying(120),
    "GovUnitName" character varying(100)
);


ALTER TABLE public."enterpriseInfoTable" OWNER TO postgres;

--
-- Name: TABLE "enterpriseInfoTable"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public."enterpriseInfoTable" IS '企业信息表';


--
-- Name: industrytableid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.industrytableid_seq
    START WITH 600001
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.industrytableid_seq OWNER TO postgres;

--
-- Name: industryTable; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."industryTable" (
    "IndustryTableID" integer DEFAULT nextval('public.industrytableid_seq'::regclass) NOT NULL,
    "IndustryName" character varying(100),
    "MajorIndustry" character varying(100)
);


ALTER TABLE public."industryTable" OWNER TO postgres;

--
-- Name: TABLE "industryTable"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public."industryTable" IS '企业行业表';


--
-- Name: townid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.townid_seq
    START WITH 700001
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.townid_seq OWNER TO postgres;

--
-- Name: townTypeTable; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."townTypeTable" (
    "TownID" integer DEFAULT nextval('public.townid_seq'::regclass) NOT NULL,
    "TownName" character varying(500)
);


ALTER TABLE public."townTypeTable" OWNER TO postgres;

--
-- Data for Name: adminInfoTable; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."adminInfoTable" ("userID", "Account", "Password", "Name", "PhoneNumber", "UserType", "Token", "Status", "IsHire", "HirerName", "HirerPhone", "CreaterAt", "GovUnitName", "TownID") FROM stdin;
500028	18365284509	\N	\N	18365284509	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTgzNjUyODQ1MDkiLCIxIjoxNTgxMjUxMTM3LCJleHAiOjE1ODEyNTgzMzd9.xXKz5kRzO3JOnzFl2PyAYcWYlOn-BJBJlUQ9Spolk4I500028	\N	1	\N	\N	2020-02-09 11:13:46	\N	\N
500025	13125356328	\N	\N	13125356328	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTMxMjUzNTYzMjgiLCIxIjoxNTgxMjY3MzA1LCJleHAiOjE1ODEyNzQ1MDV9.PYJtjCZo0StwEZUuoErj1yioxWgTzpfHM_OGdYrCNu0500025	\N	1	\N	\N	2020-02-09 09:37:15	\N	\N
500031	13335577723	\N	\N	13335577723	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTMzMzU1Nzc3MjMiLCIxIjoxNTgxMjYxOTQ0LCJleHAiOjE1ODEyNjkxNDR9.2U29FhR4bSnXUTJu2xFtRZKop2rAM_B1Dn-WWngxNjI500031	\N	1	\N	\N	2020-02-09 12:00:45	\N	\N
500033	13056878797	\N	\N	13056878797	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTMwNTY4Nzg3OTciLCIxIjoxNTgxMjY0MDM0LCJleHAiOjE1ODEyNzEyMzR9.ZqD-DjUS6mreAzkAMLGG97DRWpDmuhOidFVoKxyl4R8500033	\N	1	\N	\N	2020-02-09 12:41:07	\N	\N
500036	15728045798	\N	\N	15728045798	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTU3MjgwNDU3OTgiLCIxIjoxNTgxMjY3MzI3LCJleHAiOjE1ODEyNzQ1Mjd9.-zaQ3c-rBLIYTOGYQBkNVafo04vpfWQuUqhe8E3lJTQ500036	\N	1	\N	\N	2020-02-09 13:14:20	\N	\N
500026	18858493880	\N	\N	18858493880	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTg4NTg0OTM4ODAiLCIxIjoxNTgxMjQyNTYwLCJleHAiOjE1ODEyNDk3NjB9.53jRCqHjn8Z3qrPFqEsxnPLbkJt4DfjmSHlO0U1-GlU	\N	1	\N	\N	2020-02-09 10:02:40	\N	\N
500035	13586564027	\N	\N	13586564027	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTM1ODY1NjQwMjciLCIxIjoxNTgxMjUyNTUyLCJleHAiOjE1ODEyNTk3NTJ9.nQLjfrTM-DRX87ElI8x8OJOuVXPAv3Bu8jYD-hSiE1g	\N	1	\N	\N	2020-02-09 12:49:12	\N	\N
500039	15867217661	\N	\N	15867217661	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTU4NjcyMTc2NjEiLCIxIjoxNTgxMjY1NDIwLCJleHAiOjE1ODEyNzI2MjB9.1lJS8WOVcmt-WjJwQIPrns6mcKuvLq85VKmMBdTxPQo	\N	1	\N	\N	2020-02-09 16:23:40	\N	\N
500038	18312955414	\N	\N	18312955414	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTgzMTI5NTU0MTQiLCIxIjoxNTgxMjc2MDI4LCJleHAiOjE1ODEyODMyMjh9.cvuKNuKjwj9YCUrCrs658Bdfg89Ecc63YaaSQMsJ2Sc500038	\N	1	\N	\N	2020-02-09 15:05:51	\N	\N
500022	18829357321	\N	\N	18829357321	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTg4MjkzNTczMjEiLCIxIjoxNTgxMjc2MTA0LCJleHAiOjE1ODEyODMzMDR9.oGBOsw4S5TSbwNQefsJTfx4p1jgEBTvwBus62Ubk7pI500022	\N	1	\N	\N	2020-02-09 09:07:57	\N	\N
500030	18143770847	\N	\N	18143770847	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTgxNDM3NzA4NDciLCIxIjoxNTgxMjQ5NTAwLCJleHAiOjE1ODEyNTY3MDB9.kDGBfHUJNbcnHLNM33uw4rXlqiQtaOm0nVFFgqqndiI	\N	1	\N	\N	2020-02-09 11:58:20	\N	\N
500034	13858251304	\N	\N	13858251304	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTM4NTgyNTEzMDQiLCIxIjoxNTgxMjY1OTUwLCJleHAiOjE1ODEyNzMxNTB9.4CA6NXIQrDwDyUYEcYsvBWyMi7Gf_FTjQrHiOTSha2I500034	\N	1	\N	\N	2020-02-09 12:48:27	\N	\N
500032	15888070196	\N	\N	15888070196	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTU4ODgwNzAxOTYiLCIxIjoxNTgxMjc2MzgwLCJleHAiOjE1ODEyODM1ODB9.daA0yd4MeujTwLxEuT_hoTlx9NQIP099LOIaujWsWZQ500032	\N	1	\N	\N	2020-02-09 12:12:00	\N	\N
500037	15168123753	\N	\N	15168123753	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTUxNjgxMjM3NTMiLCIxIjoxNTgxMjU4Mjg5LCJleHAiOjE1ODEyNjU0ODl9.vip7E4rU6_u-r2y0fbzRtFWK4G2s4RgX9hX9NadR7yI	\N	1	\N	\N	2020-02-09 14:24:49	\N	\N
500023	15058296210	\N	\N	15058296210	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTUwNTgyOTYyMTAiLCIxIjoxNTgxMjY2NTA0LCJleHAiOjE1ODEyNzM3MDR9.9rCtAnfsqAHRC5WUuOqYY46OXmtdYdNPczHCuFt6aMM500023	\N	1	\N	\N	2020-02-09 09:13:15	\N	\N
500029	15056721932	\N	\N	15056721932	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTUwNTY3MjE5MzIiLCIxIjoxNTgxMjY5NjcyLCJleHAiOjE1ODEyNzY4NzJ9.fuvJtdN8-C9agwvfjYgdixvvDUM6KlCypfViGGaqlEc500029	\N	1	\N	\N	2020-02-09 11:17:10	\N	\N
500040	17612891618	$2y$10$/I35iP.J0gp0lBiEvd9JbO59BgRavKgSdT.GfpGk/G2rlY9h1dC7y	\N	17612891618	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTc2MTI4OTE2MTgiLCIxIjoxNTgxMjc3Mjg4LCJleHAiOjE1ODEyODQ0ODh9.n66fckA0JmRCymSsikaNSZ5jxouGkrrK3NeV0bEVv_A500040	\N	1	\N	\N	2020-02-09 19:39:14	\N	\N
500024	18855057970	\N	\N	18855057970	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTg4NTUwNTc5NzAiLCIxIjoxNTgxMjc3NzM3LCJleHAiOjE1ODEyODQ5Mzd9.vILEk1FqybO_c5PAR9NUHffVeFT3Odw1rQUw7Nbfhv0500024	\N	1	\N	\N	2020-02-09 09:14:36	\N	\N
500027	15888143208	\N	\N	15888143208	\N	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTU4ODgxNDMyMDgiLCIxIjoxNTgxMjczNDIzLCJleHAiOjE1ODEyODA2MjN9.B3AryokRRLWSNsIoTKhZSskikqewi4ZB9P5oHNwG4x8500027	\N	1	\N	\N	2020-02-09 10:44:45	\N	\N
\.


--
-- Data for Name: conditionInfoTable; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."conditionInfoTable" ("ConditionID", "EmployeeID", "RecordingTime", "ObservationDay", "Temperature", "MeasuringTime", "Symptom", "SymptomDesc") FROM stdin;
400012	300027	2020-02-09	0	38.88	05:31:47	3	
400013	300028	2020-02-09	-1	37.50	10:00:15	1	
400014	300030	2020-02-09	1	38.80	08:14:06	1	
400015	300035	2020-02-09	0	38.80	01:08:03	3	
400016	300037	2020-02-09	-186	36.50	01:30:48	0	
400017	300034	2020-02-09	2	36.50	01:31:53	0	
400018	300039	2020-02-09	0	38.50	02:08:43	1	
400019	300040	2020-02-09	1	36.50	02:29:20	0	
400020	300042	2020-02-09	-6	37.80	03:24:18	1	
\.


--
-- Name: conditionid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.conditionid_seq', 400020, true);


--
-- Data for Name: departmentInfoTable; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."departmentInfoTable" ("DepartmentID", "EnterpriseID", "DepartmentName", "DepartmentContacts", "PhoneNumber", "PreventionDesc", "DepartmentDesc", created_at) FROM stdin;
200011	100014	测试部门一	鄞州	055 7825 9489	良好	良好	2020-02-09 09:16:12
200012	100015	生产部	李四	139 1234 5678			2020-02-09 09:21:16
200013	100015	质量部	王二	137 1234 5678			2020-02-09 09:22:28
200014	100016	888	bty	158 8814 3208	888并且将获得授权单位时候昂品牌	888评议票	2020-02-09 10:47:48
200015	100016	123	123	127 2183 2193	21就开始销12345647890	实现萨继续拉继续看	2020-02-09 10:49:03
200016	100018	测试部门二	鄞州	123 4567 8900	测试	测试	2020-02-09 12:02:19
200017	100015	财务部	蔡富	188 1234 5678			2020-02-09 13:03:17
200018	100023	测试部门	测试	123 4567 8900	测试	测试	2020-02-09 16:44:54
200019	100024	供应链管理事业部	吴京	188 1234 5678			2020-02-09 17:00:08
200020	100024	采购部	蔡文姬	138 9876 5432			2020-02-09 17:00:31
200021	100026	部门一	SSS	123 4567 8900	测试	测试	2020-02-09 19:19:17
200022	100027	唯一部门	人				2020-02-09 19:40:19
\.


--
-- Name: departmentid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.departmentid_seq', 200022, true);


--
-- Data for Name: employeeInfoTable; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."employeeInfoTable" ("EmployeeID", "EnterpriseID", "DepartmentID", "Name", "PhoneNumber", "Gender", "Province", "City", "District", "Street", "Address", "OutgoingDesc", "ContactSituation", "LastContactDate", "ContactDesc", "OwnerHealth", "OwnerHealthDesc", "RelativesHealth", "RelativesHealthDesc", "OtherPpersonnelHealth", "OtherPpersonnelHealthDesc", "IsMedicalObservation", "MedicalObservationDesc", "MedicalObservationStartDate", "MedicalObservationEndDate", "MedicalObservationAddress", "Account", "Password", "Token", "IsHire", "HirerName", "HirerPhone", created_at, "OutgoingSituation", "OwnerStatus", "IdCardNumber", "DeparturePlace", "ReturnTraffic", "WorkTraffic", "IsLeaveNingbo", "IsFever", "Desc", "ReturnNingBoDate") FROM stdin;
300028	100015	200013	周虎	135 1123 4567	0	\N	\N	\N	\N	首南街道首南三路299号5栋201	2020-02-11	1	2020-02-10	亲戚朋友，聚会，面对面交流	0		0		\N	\N	1	\N	2020-02-11	2020-02-25	\N	13125356328	\N	\N	1	钱坤	132 1234 5678	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N
300029	100014	200011	XXX	123 4567 8900	0	\N	\N	\N	\N	宁波市鄞州区鄞州信息科技孵化园E栋911	\N	0	\N		0		0		\N	\N	0	\N	\N	\N	\N	15056721932	\N	\N	1	李	123 4567 8900	\N	4	\N	\N	\N	\N	\N	\N	\N	\N	\N
300030	100018	200016	XXX	123 4567 8900	0	\N	\N	\N	\N	宁波市鄞州区鄞州信息科技孵化园	\N	1	\N	见面	1		3		\N	\N	1	\N	2020-02-09	2020-02-23	\N	13335577723	\N	\N	1	李	123 4567 8900	\N	4	\N	\N	\N	\N	\N	\N	\N	\N	\N
300031	100018	200016	LLL	123 4567 8900	0	\N	\N	\N	\N	宁波市	\N	0	\N		0		0		\N	\N	0	\N	\N	\N	\N	18365284509	\N	\N	1	李	123 4567 8900	\N	4	\N	\N	\N	\N	\N	\N	\N	\N	\N
300032	100018	200016	陈家乐	138 5825 1304	0	\N	\N	\N	\N	啦啦啦啦啦	2020-02-09	1	2020-02-07	啦啦啦啦阿拉了	0		0		\N	\N	1	\N	2020-02-09	2020-02-23	\N	13858251304	\N	\N	0			\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N
300033	100018	200016	余德行	183 1295 5414	0	\N	\N	\N	\N	大大的	\N	1	\N	大大的	2		2		\N	\N	1	\N	2020-02-06	2020-02-20	\N	18312955414	\N	\N	0			\N	4	\N	\N	\N	\N	\N	\N	\N	\N	\N
300037	100023	\N	骆鸿益	157 8589 6586	0	\N	\N	\N	\N	是卡卡卡卡卡卡卡卡卡卡啦啦啦啦	\N	1	\N	不认识	0		0		\N	\N	1	\N	2020-08-14	2020-08-28	\N	15728045798	\N	\N	0			\N	4	\N	\N	\N	\N	\N	\N	\N	\N	\N
300034	100023	\N	孙华	158 8807 0196	0	\N	\N	\N	\N	那是肯定开的空空荡荡空空的口袋	2020-02-08	1	2020-02-06	可么么哒吗	1		4	看到你分分秒秒分	\N	\N	1	\N	2020-02-08	2020-02-22	\N	15888070196	\N	\N	1	世纪大口大口大口	466 4567 6767	\N	2	\N	\N	\N	\N	\N	\N	\N	\N	\N
300041	100023	200018	TY	158 8814 3208	1	\N	\N	\N	\N	海曙区	\N	1	\N	哈流批	0		1		\N	\N	1	\N	2020-02-10	2020-02-24	\N	15888143208	\N	\N	0			\N	4	\N	\N	\N	\N	\N	\N	\N	\N	\N
300042	100026	200021	胡有恒	188 2935 7321	0	\N	\N	\N	\N	哈哈	2020-02-16	0	\N		0		0		\N	\N	1	\N	2020-02-16	2020-03-01	\N	18829357321	\N	\N	0			\N	2	\N	\N	\N	\N	\N	\N	\N	\N	\N
300043	100027	200022	水水水水	111 1111 1111	0	\N	\N	\N	\N	111111111111111	2020-02-10	0	\N		0		0		\N	\N	1	\N	2020-02-10	2020-02-24	\N	17612891618	\N	\N	0			\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Name: employeeid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.employeeid_seq', 300043, true);


--
-- Data for Name: enterpriseInfoTable; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."enterpriseInfoTable" ("EnterpriseID", "EnterpriseName", "District", "Address", "StartDate", "Contacts", "PhoneNumber", "PreventionDesc", "EnterpriseScale", "EmployeesNumber", "Account", "Password", "Token", "BackEmpNumber", "ProductingPlan", "TownID", "Industry", "IndustryTableID", "OrganizationCode", "GovUnitName") FROM stdin;
100015	宣仪科技	鄞州区	首南中路398号	2020-02-15	张毅	13812345678	准备完成	1	50000	15058296210	\N	2LuFqHx8S6vVmypg7f3inUClKbdj5WtB100015	50	\N	700020	汽车玻璃生产商	\N	\N	\N
100016	666	鄞州区	666街道	2020-02-10	bty	15888143208	123456	1	1234	15888143208	\N	algdj8BV9JnF1sqI7TXZRKMt6yQoe2i5100016	123	\N	700001	技术	\N	\N	\N
100017	测试二	鄞州区	鄞州	2020-02-10	鄞州	12345678900	良好	1	88	15056721932	\N	MNK21PsZ5pI0l8VqChamjkALruROydvB100017	66	\N	700001	更新技术	\N	\N	\N
100018	测试三	鄞州区	鄞州	2020-02-10	鄞州	12345678900	良好	1	99	13335577723	\N	wCZJFoGBQYcdz04nu12XHgiSVRLbfltW100018	66	\N	700002	高新技术	\N	\N	\N
100019	把偶喝酒	鄞州区	姐姐嗯呢	2020-02-10	很多简单	11656898686	j w k d k f k f	1	156868	15888070196	\N	02M7UJ6gNcZ8wsOaySWAm9Yd5ktBozuv100019	85	\N	700011	就飞机哦	\N	\N	\N
100022	13858251304	鄞州区	啦啦啦	2020-02-10	13858251304	13858251304	098768755	0	876	13858251304	\N	EzWr8UklbQR0ujPZpftH7X6MSF9qTiyB100022	875	\N	700005	丙级	\N	\N	\N
100024	金东科技	鄞州区	首南三路269号	2020-02-15	刘强东	13812345678	已完成复工准备工作	1	5000	13125356328	\N	AhSnfzC2bV07HgOImDMxeRk18oTFLKG3100024	356	\N	700001	甲级	\N	\N	\N
100025	ydx	鄞州区	21	2020-02-10	21	2121	2	1	111	18312955414	\N	RNx8HGV76ftpLiesA1aBb0nPQ5vFJdqj100025	22	null	700006	12121212	600002	2	农业农村局
100026	测试企业	鄞州区	鄞州区	2020-02-10	谁知道	12345678900	不造啊	1	100	18855057970	\N	ELAd27MI3UV0Yez6TwamytRjcWh18vFx100026	18	\N	700005	甲级	\N	\N	\N
100027	测试测试测试测试	鄞州区	的点点滴滴多多	2020-02-10	的点点滴滴多多多	11111111111	测试测试	1	11111	17612891618	\N	U53pcoL84MYB1VWdIvbQZluGsEgwAhxP100027	111	\N	700001	甲级	\N	\N	\N
\.


--
-- Name: enterpriseid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.enterpriseid_seq', 100027, true);


--
-- Data for Name: industryTable; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."industryTable" ("IndustryTableID", "IndustryName", "MajorIndustry") FROM stdin;
600001	农业	农业农村局
600002	林业	农业农村局
600003	畜牧业	农业农村局
600004	农副业	农业农村局
600005	渔业	农业农村局
600006	工业	经信局
600007	建筑业	住建局
600008	房地产	住建局
600009	外贸	商务局
600010	商贸	商务局
600011	餐饮	商务局
600012	住宿	商务局
600013	家政	商务局
600014	航运物流	商务局
600015	商务服务	商务局
600016	金融业	金融办
600017	文化产业	文广旅体局
600018	广电	文广旅体局
600019	旅游	文广旅体局
600020	星级酒店	文广旅体局
600021	客运	交通局
600022	货运	交通局
600023	仓储	交通局
600024	农贸市场	市场监管局
600025	国有企业	国资中心
600026	其他	其他
\.


--
-- Name: industrytableid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.industrytableid_seq', 600001, false);


--
-- Data for Name: townTypeTable; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."townTypeTable" ("TownID", "TownName") FROM stdin;
700001	海曙区
700002	江北区
700003	镇海区
700004	北仑区
700005	鄞州区
700006	奉化区
700007	余姚市
700008	慈溪市
700009	宁海县
700010	象山县
\.


--
-- Name: townid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.townid_seq', 700021, true);


--
-- Name: userid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.userid_seq', 500040, true);


--
-- Name: adminInfoTable adminInfoTable_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."adminInfoTable"
    ADD CONSTRAINT "adminInfoTable_pkey" PRIMARY KEY ("userID");


--
-- Name: conditionInfoTable conditionInfoTable_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."conditionInfoTable"
    ADD CONSTRAINT "conditionInfoTable_pkey" PRIMARY KEY ("ConditionID");


--
-- Name: departmentInfoTable departmentInfoTable_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."departmentInfoTable"
    ADD CONSTRAINT "departmentInfoTable_pkey" PRIMARY KEY ("DepartmentID");


--
-- Name: employeeInfoTable employeeInfoTable_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."employeeInfoTable"
    ADD CONSTRAINT "employeeInfoTable_pkey" PRIMARY KEY ("EmployeeID");


--
-- Name: enterpriseInfoTable enterpriseInfoTable_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."enterpriseInfoTable"
    ADD CONSTRAINT "enterpriseInfoTable_pkey" PRIMARY KEY ("EnterpriseID");


--
-- Name: industryTable industryTable_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."industryTable"
    ADD CONSTRAINT "industryTable_pkey" PRIMARY KEY ("IndustryTableID");


--
-- Name: townTypeTable townTypeTable_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."townTypeTable"
    ADD CONSTRAINT "townTypeTable_pkey" PRIMARY KEY ("TownID");


--
-- Name: company_token_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX company_token_index ON public."enterpriseInfoTable" USING btree ("Token");


--
-- Name: department_company_index_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX department_company_index_id ON public."departmentInfoTable" USING btree ("EnterpriseID");


--
-- Name: department_name_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX department_name_index ON public."departmentInfoTable" USING btree ("DepartmentName");


--
-- Name: user_phone_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX user_phone_index ON public."adminInfoTable" USING btree ("PhoneNumber");


--
-- PostgreSQL database dump complete
--

