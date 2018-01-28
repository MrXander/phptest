SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: 'Customers'
--

-- --------------------------------------------------------

--
-- Table structure for table 'Customer'
--

CREATE TABLE 'Customer' (
  'Id' int NOT NULL,
  'Name' varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'Customer'
--

INSERT INTO 'Customer' ('Id', 'Name') VALUES
(1, 'First customer'),
(2, 'Second customer');

--
-- Indexes for table 'Customer'
--
ALTER TABLE 'Customer'
  ADD PRIMARY KEY ('Id');
ALTER TABLE 'Customer' ADD FULLTEXT KEY 'IDX_Name' ('Name');

--
-- AUTO_INCREMENT for table 'Customer'
--
ALTER TABLE 'Customer'
  MODIFY 'Id' int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
