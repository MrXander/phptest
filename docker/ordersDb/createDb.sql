SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: 'Orders'
--

-- --------------------------------------------------------

--
-- Table structure for table 'Orders'
--

CREATE TABLE 'Orders' (
  'Id' int NOT NULL,
  'Title' varchar(200) NOT NULL,
  'Description' varchar(1000) NOT NULL,
  'Price' decimal(10,2) UNSIGNED NOT NULL,
  'Status' tinyint UNSIGNED NOT NULL DEFAULT '0',
  'CustomerId' int UNSIGNED NOT NULL,
  'ContractorId' int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'Orders'
--

INSERT INTO 'Orders' ('Id', 'Title', 'Description', 'Price', 'Status', 'CustomerId', 'ContractorId') VALUES
(1, 'First order', 'super long description', '555.66', 0, 1, NULL);


ALTER TABLE 'Orders'
  ADD PRIMARY KEY ('Id');


ALTER TABLE 'Orders'
  MODIFY 'Id' int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
