CREATE TABLE IF NOT EXISTS `user` (
  `userID` varchar(30) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `usertype` tinyint(1) NOT NULL,
  `secQuestion` int(3) NOT NULL,
  `secanswer` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-----------------------------------------------------

CREATE TABLE IF NOT EXISTS `volReq` (
    `userID` varchar(30) NOT NULL,
    `usertype` tinyint(1) NOT NULL,