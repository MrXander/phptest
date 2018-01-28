SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: 'Contractors'
--

-- --------------------------------------------------------

--
-- Table structure for table 'Contractor'
--

CREATE TABLE 'Contractor' (
  'Id' int(11) NOT NULL,
  'Name' varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'Contractor'
--

INSERT INTO 'Contractor' ('Id', 'Name') VALUES
(1, 'First contractor');

--
-- Indexes for table 'Contractor'
--
ALTER TABLE 'Contractor'
  ADD PRIMARY KEY ('Id');
ALTER TABLE 'Contractor' ADD FULLTEXT KEY 'IDX_Name' ('Name');

--
-- AUTO_INCREMENT for table 'Contractor'
--
ALTER TABLE 'Contractor'
  MODIFY 'Id' int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
