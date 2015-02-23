<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Course status block - text strings
 *
 * @package    course_status
 * @category   block
 * @copyright  2015, Oxford Brookes University {@link http://www.brookes.ac.uk/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$string['pluginname'] = 'Course status';
$string['coursestatus'] = 'Course status';
$string['coursestatus:addinstance'] = 'Add a new course status block';
$string['coursestatus:myaddinstance'] = 'Add a new course status block to the My Moodle page';

$string['requirerelease'] = "Requiring release";
$string['requirecontent'] = "Requiring content";

$string['forthcoming'] = "Forthcoming courses:";
$string['reminderstart'] = "Before releasing your course(s), please ensure you have ";
$string['reminderlink'] = "completed the course checklist";


$string['mindays'] = "Start (days)";
$string['mindaysdesc'] = "Minimum number of days to look ahead (default 0, can be negative)";
$string['maxdays'] = "Lookahead (days)";
$string['maxdaysdesc'] = "Maximum number of days to look ahead (default 90)";
$string['alertdays'] = "Overdue days";
$string['alertdaysdesc'] = "Days before course is considered overdue, shown with red text in block (default 0 - today, eg 7 for next week, -7 for last week) ";
$string['alertmodules'] = "Minimum course elements";
$string['alertmodulesdesc'] = "Number of course elements below which the query will alert course as needing content/rollover (default 5)";
$string['excludetext'] = "Exclude category";
$string['excludetextdesc'] = "Category name to exclude from alerts (eg 'Non-PIP Linked Courses'), if any";
