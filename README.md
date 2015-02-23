moodle-block_course_status
==========================

Displays all upcoming courses for which the current user is in a teacher role and which are either not yet visible or have little content.

<h2>USAGE</h2>

The course status block can be added to pages as any other block (it is suggested that it be added to all /my pages, and promoted somewhere near or at the top).

It displays in the block all courses starting in the near future (see settings) for which the current user is in a teacher role and which are either not yet visible or have a small amount of content (see settings). If any of these courses have not been checked against the checklist, a link to the checklist is also displayed.

The settings of this block will set the number of days to look ahead to pick up courses (defaults to starting today, lookahead 90 days), and the number of activities required in a course before it will be flagged as needing content/rollover.

<h2>INSTALLATION</h2>

This block and the coursechecklist plugin are mutually dependant.

This should be installed in the blocks directory of the Moodle instance.
