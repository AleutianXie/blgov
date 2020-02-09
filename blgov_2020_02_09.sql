--
-- PostgreSQL database dump
--

-- Dumped from database version 11.6 (Ubuntu 11.6-1.pgdg18.04+1)
-- Dumped by pg_dump version 11.6 (Ubuntu 11.6-1.pgdg18.04+1)

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
    "CreaterAt" timestamp without time zone
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
    "OutgoingSituation" smallint
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
    "Industry" character varying(500)
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

