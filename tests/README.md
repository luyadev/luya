TESTS
=====


Database Setup for Unittests.

Login: test@luya.io
Password: testluyaio


Additional structure to luya kickstarter
-----

```
--
-- Table structure for table `dummy_table`
--

CREATE TABLE IF NOT EXISTS `dummy_table` (
`id` int(11) NOT NULL,
  `i18n_text` text NOT NULL,
  `i18n_textarea` text NOT NULL,
  `date` int(11) NOT NULL,
  `datetime` int(11) NOT NULL,
  `file_array` text NOT NULL,
  `image_array` text NOT NULL,
  `select` int(11) NOT NULL,
  `cms_page` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dummy_table`
--
ALTER TABLE `dummy_table`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dummy_table`
--
ALTER TABLE `dummy_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
```