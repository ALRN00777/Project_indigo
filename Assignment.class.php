<?php
class Assignment{

    public $maxQuestions;
    public $quesPerChapter;
    public $chapProgress = array();
    public $chapList = array("test");
    public $index = 0;
    public $usedQuestions = array();
    public $connection;
    public $totalQuestions;

    public function __construct($maxQuestions, $chapList, $quesPerChapter, $DBconnection){
        $this->maxQuestions = $maxQuestions;
        $this->chapList = $chapList;
        $this->quesPerChapter = $quesPerChapter;
        var_dump($this->chapList);
    }

    public function generateQuestion(){

        require_once 'config/config.php';

        $this->connection = $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if(sizeof($this->chapProgress) == $this->quesPerChapter){
            $this->chapProgress = array();
            $this->index++;				
        }		

        $this->totalQuestions = $this->connection->query("SELECT COUNT(*) FROM ".$this->chapList[$this->index]);
        $this->totalQuestions = $this->totalQuestions->fetch_array(MYSQLI_NUM);

        do{
            //Choosing a random index between 1 and the number of questions there are in the table. This number will be used to
            //choose a random question from the table and it's associated answer set.
            $Q_ID = rand(1,$this->totalQuestions[0]);

        }while(in_array($Q_ID, $this->chapProgress));

        array_push($this->chapProgress, $Q_ID);

        array_push($this->usedQuestions, $Q_ID);



        $question_Query = "SELECT Question FROM ".$this->chapList[$this->index]." WHERE Q_ID=$Q_ID";

        $answer_Query = "SELECT Answer,W_Answer_1,W_Answer_2,W_Answer_3 FROM ".$this->chapList[$this->index]." WHERE Q_ID=$Q_ID";

        $Hint_Query = "SELECT Hint FROM ".$this->chapList[$this->index]." WHERE Q_ID=$Q_ID";



        $question = $this->connection->query($question_Query);
        $question = $question->fetch_array(MYSQLI_NUM);
        $_SESSION{'question'} = $question;

        $answers = $this->connection->query($answer_Query);
        $answers = $answers->fetch_array(MYSQLI_NUM);
        $_SESSION['answers'] = $answers;

        $Hint = $this->connection->query($Hint_Query);
        $Hint = $Hint->fetch_array(MYSQLI_NUM);
        $_SESSION{'Hint'} = $Hint;
    }

    public function getMaxQuestions(){
        return $this->maxQuestions;
    }

    public function getUsedQuestions(){
        return $this->usedQuestions;
    }

    public function getChapList(){
        return $this->chapList;
    }

    public function getCurrentChap(){
        return $this->chapList[$index];
    }

    public function getQuesPerChapter(){
        return $this->quesPerChapter;
    }

}