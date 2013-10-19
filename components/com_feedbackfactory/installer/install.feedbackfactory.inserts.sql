INSERT INTO `#__feedback_categories` (`id`, `title`,`published`, `ordering`) VALUES 
(1, 'Test category', 1, 1);

INSERT INTO `#__feedback_statuses` (`id`, `status`,`default_status`, `published`) VALUES
(1, 'Accepted pending','Accepted pending', 1),
(2, 'Accepted started','Accepted started', 1),
(3, 'Accepted planned','Accepted planned', 1),
(4, 'Completed','Completed', 1),
(5, 'Declined', '',1),
(6, 'None','None', 1);
