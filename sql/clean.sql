--
-- Table structure for table `feeding`
--

CREATE TABLE `feeding` (
	  `feeding_id` int(11) NOT NULL,
	  `feeding_time` datetime NOT NULL,
	  `type_id` tinyint(4) NOT NULL,
	  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
	  `type_id` tinyint(4) NOT NULL,
	  `type_name` text NOT NULL,
	  `type_colour` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Indexes for table `feeding`
--
ALTER TABLE `feeding`
  ADD PRIMARY KEY (`feeding_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for table `feeding`
--
ALTER TABLE `feeding`
  MODIFY `feeding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;
--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `type_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
