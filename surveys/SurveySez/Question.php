<?php
//Question.php
namespace SurveySez;

class Question
{
	 public $QuestionID = 0;
	 public $Text = "";
	 public $Description = "";
	 public $aAnswer = Array();#stores an array of answer objects
	 public $TotalAnswers = 0;
	/**
	 * Constructor for Question class. 
	 *
	 * @param integer $id ID number of question 
	 * @param string $question The text of the question
	 * @param string $description Additional description info
	 * @return void 
     * @todo none
	 */ 
    function __construct($id,$question,$description)
	{#constructor sets stage by adding data to an instance of the object
		$this->QuestionID = (int)$id;
		$this->Text = $question;
		$this->Description = $description;
	}# end Question() constructor
	
	/**
	 * Reveals answers in internal Array of Answer Objects 
	 * for each question 
	 *
	 * @param none
	 * @return string prints data from Answer Array 
	 * @todo none
	 */ 
	function showAnswers()
	{
		$myReturn = '';
        $counter = 0;
        foreach($this->aAnswer as $answer)
		{#print data for each
			$myReturn .= " " . $answer->Text . " ";
			if($answer->Description != "")
			{#only print description if not empty
				$myReturn .= "<em>(" . $answer->Description . ")</em>";
			}
            $counter++;
            if(count($this->aAnswer)>$counter)
            {
               $myReturn .= '<br />'; 
            }
		}
		//$myReturn .= "<br />";
        return $myReturn;
        
	}#end showAnswers() method
}# end Question class