<?php

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
          $data['row'] = $this->data_collection("COMP",232,4);
          $this->load->view('test_view.php',$data);
	}
	
	public function open()
	{
          $this->load->view('welcome_message.php');
        }
        
        private function data_collection($course,$course_number,$season){
          $this->load->library('simple_html_dom.php');
          $html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=20114&course=ENGR&courno=201&campus=&type=U');
          $row = $html -> find('td');

          $course_lecture = array();

          for($i=9; $i<=sizeOf($row)-1; $i++){
          //trim only remove beginning and end white space, text() is used to get the text of html element
            if( strcasecmp(trim($row[$i]->text()), "ENGR 201") === 0){
                $course_title = $row[$i+1]-> text();
                $credit = $row[$i+2]-> text();
                echo "Course Title:".$course_title."<br>Credit:".$credit;
            }
            if (preg_match("/^Lect\s\w+/", $row[$i]->text(),$matches)){
              $lecture_title = trim($row[$i]->text());
              $tutorials = $this->get_tutorials($i, $row);
              $course_lecture[$lecture_title] = array("Time" => trim($row[$i+1]->text()), "Location" => trim($row[$i+2]->text()), "Teacher" => trim($row[$i+3]->text()));
            }
          }
         //print_r($course_lecture);
         return $html -> find('td');
        }

        
        private function get_tutorials($index, $row){
          $tutorial_sections = array();
          for($index; $index<=sizeOf($row)-1; $index++){
            $text = trim($row[$index]->text());
            if(preg_match("/Tut\s\w+/",$text)){
              $tutorial_info[trim($text, " \t.")] = array( "Time" => trim($row[$index+1]->text()), "Location" => trim($row[$index+2]->text()));
            }
          }
        print_r($text);
        }
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */