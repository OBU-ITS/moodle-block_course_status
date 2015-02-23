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
 * Course status block - admin settings
 *
 * @package    course_status
 * @category   block
 * @copyright  2015, Oxford Brookes University {@link http://www.brookes.ac.uk/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

    
$settings->add(new admin_setting_configtext('block_course_status/mindays', 
                                            get_string('mindays', 'block_course_status'),
                                            get_string('mindaysdesc', 'block_course_status'), 
                                            '0',
                                            PARAM_INT));
$settings->add(new admin_setting_configtext('block_course_status/maxdays', 
                                            get_string('maxdays', 'block_course_status'),
                                            get_string('maxdaysdesc', 'block_course_status'), 
                                            '90',
                                            PARAM_INT));    

$settings->add(new admin_setting_configtext('block_course_status/alertmodules', 
                                            get_string('alertmodules', 'block_course_status'),
                                            get_string('alertmodulesdesc', 'block_course_status'), 
                                            '5',
                                            PARAM_INT));        

$settings->add(new admin_setting_configtext('block_course_status/alertdays', 
                                            get_string('alertdays', 'block_course_status'),
                                            get_string('alertdaysdesc', 'block_course_status'), 
                                            '0',
                                            PARAM_INT));    

$settings->add(new admin_setting_configtext('block_course_status/excludetext', 
                                            get_string('excludetext', 'block_course_status'),
                                            get_string('excludetextdesc', 'block_course_status'), 
                                            '',
                                            PARAM_TEXT));   


    

