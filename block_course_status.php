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
 * Display course status for module leaders (rollover, checklists and other things that need attention)
 *
 * @package    course_status
 * @category   block
 * @copyright  2015, Oxford Brookes University {@link http://www.brookes.ac.uk/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 

class block_course_status extends block_base {
    public function init() {
        $this->title = get_string('coursestatus', 'block_course_status');
    }

	/**
	 * Generate content of the block
	 * 
	 * @global type $CFG
	 * @global type $USER
	 * @return type
	 */    
		  
	 public function get_content() {
		
		global $CFG, $USER; 
		require_once($CFG->libdir . '/coursecatlib.php');
		
		require_once('lib.php');
		require_once('dbquery.php');
		 
		if ($this->content !== null) {
		  return $this->content;
		}

		$this->content         =  new stdClass;
		$this->content->text   = '';    
								
		$courses = array();
		$count = 0;
		
		// Get the master category list (so we can exclude the ones that won't be relevant eg non-PIP)
		// I hope this is cached (core Moodle) and isn't recalculated every time (but see https://tracker.moodle.org/browse/MDL-40276 )
		$displaylist =  coursecat::make_categories_list();
		// $parentlist = coursecat::get_parents();    
		  
		$courses = get_pending_courses($count, $USER->id);
	 
		// $this->content->text   .= "<b>". get_string('forthcoming', 'block_course_status') . "</b><br>";  
		
		$new_course_list = "";
		$empty_course_list = "";
		$new_courses = array(); // track the IDs of new courses so we can check them against the DB/checklist
		
		foreach ($courses as $course) {
			
			// Here we make some decisions about what to include, what not to include, and where
			// viz:
			// - exclude non-PIP linked (in the category) - or as set by settings
			// - include not visible in list of due to make live (checklist link)
			// - include little or no content (modules < x) in list of rollovers to do
			
			// So first - exclude the category we want to exclude
			$exclude = get_config('block_course_status', 'excludetext');
			if ($exclude && !(strpos($displaylist[$course->category], $exclude) >= 0)) {
				continue;
			}
			// If not visible include in list to be made visible (and show checklist, somewhere)
			if (!($course->visible)) {
				
				$new_courses[] = $course->id;
				
				$new_course_list .= $this->print_course_link($course);
			   
				//if the start date is today or in the past, show visual alert (red text)
				if ($course->days <= get_config('block_course_status', 'alertdays')) {
					$new_course_list .= " (starting " . "<span style='font-weight:bold'>" . $course->start . "</span>)";
				}
				else {
					$new_course_list .= " (starting " . $course->start . ")";  
				}
				
				$new_course_list .= "<br>";              
			}
					
			// If no content, (modules less than 5, say, allowing for forum, guide etc) include in list to be rolled over to
			if ($course->modules < get_config('block_course_status', 'alertmodules')) {
				$empty_course_list .= $this->print_rollover_link($course);
				$empty_course_list .= " (starting " . $course->start . ")";
				$empty_course_list .= "<br>";   
			}
		
			// $this->content->text   .= " " . $displaylist[$course->category];
		   
		}    

		if ($new_course_list) {
			
			// Look up in DB if ANY of the new course IDs have been checked against the checklist 
			// if so no need to show the link again, otherwise it gets shown.
			
			$checklist_link = "";
			if (!($this->check_course_checklist($new_courses))) {
				// $checklist_link = "Before releasing your course(s), please ensure you have <a href=\"\">checked the checklist</a><br>";
			
				$checklist_link = html_writer::tag("span", get_string('reminderstart', 'block_course_status'));
				$checklist_link .= html_writer::link("/local/coursechecklist/checklist_form.php?courseids=".implode($new_courses,","), get_string('reminderlink', 'block_course_status'), array("style"=>"color:red"));
				$checklist_link .= "<br>";
			}
			
			$new_course_list = "<br><b>" . get_string('requirerelease', 'block_course_status') . "</b><br>" . $checklist_link . $new_course_list;
			$this->content->text .= $new_course_list;   
		}
		if ($empty_course_list) {
			$this->content->text   .= "<br><b>" . get_string('requirecontent', 'block_course_status') . "</b><br>" . $empty_course_list;   
		}
		
		// However if there's nothing to show, then show nothing
		if (!$new_course_list && !$empty_course_list) {
			$this->content->text = "";
		}
	   
		return $this->content;
	}
	  
	/** Print standard course link
	 * 
	 * @param type $course
	 * @return type
	 */

	public function print_course_link($course) {
		
		// Alternative approach would be to link direct to edit page, such as /course/edit.php?id=?
		
		$linkhref = new moodle_url('/course/view.php', array('id'=>$course->id));
		$coursename = get_course_display_name_for_list($course);
		$linktext = format_string($coursename);
		$linkparams = array('title'=>get_string('entercourse'));
		
		if ($course->days <= get_config('block_course_status', 'alertdays')) {
			$linkparams['style'] = 'color:red';
		}
		
		/* // They are all not visible here so don't dim
		if (empty($course->visible)) {
			$linkparams['class'] = 'dimmed';
		}
		*/
		
		return html_writer::link($linkhref, $linktext, $linkparams);    
	}

	/** Print link to course rollover
	 * 
	 * @param int $course course id
	 * @return string the link
	 */

	public function print_rollover_link($course) {
		
		$linkhref = new moodle_url('/local/manualrollover/manualrollover.php', array('id'=>$course->id, 'rtype'=>'to'));
		$coursename = get_course_display_name_for_list($course);
		$linktext = format_string($coursename);
		$linkparams = array('title'=>get_string('entercourse'));
		
		if ($course->days <= get_config('block_course_status', 'alertdays')) {
			$linkparams['style'] = 'color:red';
		}
		
		return html_writer::link($linkhref, $linktext, $linkparams);    
	}

	/** Checks to see if ANY courses in list have been checked against the checklist.
	 *  If ANY have NOT, then the link will be displayed
	 * 
	 * @param array $new_course_list
	 * @return int
	 */

	public function check_course_checklist($new_course_list) {
		   
		$course_include = "(";
		
		// build an sql list include of the IDs
		foreach ($new_course_list as $course) {
			if ($course_include != "(") {
				$course_include .= ",";
			}
			$course_include .= $course;
			  
		}
		$course_include .= ")";
		
		return count_checklist_for_courses($course_include);
	}

	/**
	 * Allow block multiples
	 * 
	 * @return boolean
	 */
	  
	public function instance_allow_multiple() {
	  return false;
	}

	/**
	 * Allow the block to have a configuration page
	 *
	 * @return boolean
	 */

	public function has_config() {
		return true;
	}

	/**
	 * Locations where block can be displayed
	 *
	 * @return array
	 */

	public function applicable_formats() {
		return array('my-index' => true);
	}
}
 






