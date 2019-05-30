<?php
/**
 * survey_view.php along with index.php allows us to view surveys
 * 
 * @package SurveySez
 * @author David Nguyen <davidnguyen234@gmail.com>
 * @version 1 2019/05/09
 * @link http://www.example.com/
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{ //send use back to a safe page
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}

//sql statement to select individual item
//$sql = "select Title, Description, DateAdded from sp19_surveys where SurveyID = " . $myID;

//---end config area --------------------------------------------------

$foundRecord = FALSE; # Will change to true, if record found!

$mySurvey = new Survey($myID);

dumpDie($mySurvey);
   
# connection comes first in mysqli (improved) function
/*$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	   $foundRecord = TRUE;	
	   while ($row = mysqli_fetch_assoc($result))
	   {
			$Title = dbOut($row['Title']);
			$Description = dbOut($row['Description']);
			$DatedAdded = dbOut($row['DateAdded']);
	   }
}

@mysqli_free_result($result); # We're done with the data! */

if($foundRecord)
{#only load data if record found
	$config->titleTag = $Title . 'survey'; #overwrite PageTitle with
}

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
if($foundRecord)
{#records exist - show survey!
	echo '
	<h3 align="center">' . $Title . '</h3>
	<p>' . $Description . '</p>
	<p>Date added: ' . $DatedAdded . '</p>
		
	';
}else{//no such muffin!
    echo '<div align="center">There is no such survey</div>';
    echo '<div align="center"><a href="' . VIRTUAL_PATH . 'surveys/index.php">Surveys</a></div>';
}

get_footer(); #defaults to theme footer or footer_inc.php

class Survey{
	public $SurveyID = 0;
	public $Title = '';
	public $Description = '';
	public $DateAdded = '';
	public $Questions = array();

	public function __construct($id){
		$this->SurveyID = (int)$id;

		//sql statement to select individual item
		$sql = "select Title, Description, DateAdded from sp19_surveys where SurveyID = " . $this->SurveyID;

		$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

		if(mysqli_num_rows($result) > 0)
		{#records exist - process
	 	$foundRecord = TRUE;	
	 	while ($row = mysqli_fetch_assoc($result))
	   	{
			$this->$Title = dbOut($row['Title']);
			$this->$Description = dbOut($row['Description']);
			$this->$DatedAdded = dbOut($row['DateAdded']);
	   }
		}

		@mysqli_free_result($result); # We're done with the data!



		//sql statement to select individual item
		$sql = "select QuestionID, Description, Question from sp19_question where SurveyID = " . $this->SurveyID;

		$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

		if(mysqli_num_rows($result) > 0)
		{#records exist - process
	 	while ($row = mysqli_fetch_assoc($result))
	   	{
			$this->Question[]=new Question(dbOut($row['QuestionID']),dbOut($row['Question']),dbOut($row['Description']));


			/*
			$this->$Title = dbOut($row['Title']);
			$this->$Description = dbOut($row['Description']);
			$this->$DatedAdded = dbOut($row['DateAdded']);
			*/
	   }
		}

		@mysqli_free_result($result); # We're done with the data!


	}//end Survey constructor


}//end Survey class

class Question {
	public $SurveyID = 0;
	public $Title = '';
	public $Description = '';

	public function __construct($QuestionID,$QuestionName,$Description){
		$this->QuestionID = $QuestionID;
		$this->QuestionName = $QuestionName;
		$this->Description = $Description;
	}
}//end Question class