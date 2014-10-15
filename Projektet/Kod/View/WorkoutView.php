<?php
namespace View;

class WorkoutView{
	private $today;
	private $time = '00:00:00';
	private $addWorkout;
	private $updateWorkout;
	private $deleteWorkout;
	private $message = '';
	private $submitAdd;
	private $dateAdd;
	private $typeAdd;
	private $distanceAdd;
	private $timeAdd;
	private $minutesAdd;
	private $secondsAdd;
	private $hoursAdd;
	private $commentAdd;
	

	public function __construct(){
		$this->today = date("Y-m-d");
	}
	
	public function userMenu($username){
		$html= "
		<div class='row'>
		<div class='col-xs-12 col-sm-12'>
		<div id ='usermenu'>
        <p>Inloggad som " . $username . " <a id='logoutlink' href='?action=".NavigationView::$actionSignOut."'>Logga ut</a></p>
        </div>
        </div>
        </div>";
		return $html;
	}

	public function workoutList($workoutList){
		$resultsrow='';
		foreach ($workoutList as $workout) {
			$resultsrow .= '<tr>
								<td>'.$workout->getDate().'</td>
								<td>'.$workout->getWorkoutTypeName().'</td>
								<td>'.$workout->getDistance().'</td>
								<td>'.$workout->getTime().'</td>
								<td>'.$workout->getAverage().'</td>
								<td>'.$workout->getComment().'</td>
								<td><input type="submit" value="Radera" name="submit_delete" class="btn btn-default">
									<input type="submit" value="Ändra" name="submit_update" class="btn btn-default"></td>
							<tr>';
		}
		$html= "
			<div class 'row'>
			<div class='col-xs-12'>
			<div id='workoutTable' class='table-responsive'>
			<table class='table table-bordered table table-striped '>
				<h2 id='headertext'>Dina träningspass</h2>
				<p><a id='link_add' href='?addWorkout'>Lägg till</a></p>
				<tr>
					<th>Träningsdatum</th>
					<th>Typ</th>
					<th>Distans (km)</th>
					<th>Tid</th>
					<th>Snitt(/km)</th>
					<th>Kommentar</th>
					<th>Val</th>
				<tr>"
				.$resultsrow."
			</table>
			</div>
			</div>
			</div>
		";
		return $html;
	}

	public function clickedAdd(){
		if (isset($_GET['addWorkout'])) {
			return TRUE;
		}
		return FALSE;
	}


	public function addWorkoutForm($workoutTypes){
		$optionValues='';
		foreach ($workoutTypes as $workoutType) {
			$optionValues .= '
							<option value='.$workoutType->getWorkoutTypeId().'>'.$workoutType->getName().'</option>
							';
							$this->typeAdd = $workoutType->getWorkoutTypeId();
		}
		$html= "
		<div class='row' id='add_table'>
		<div class='col-xs-12'>
        <h3>Nytt träningspass</h3>
        <div id='link'><a href='./'>Tillbaka till översikt</a></div>
        <p>$this->message</p>
        <div class='col-xs-12 col-sm-6'>
        <form method='post' role='form' action='?addWorkout'> 
        	<div class='form-group'>
        	<label for='dateAdd'>Träningsdatum</label>
            <input type='date' class='form-control' maxlength='10' name='dateAdd' id='dateAdd' value='$this->today' min='2014-01-01' max='$this->today'>
            </div>
            <div class='form-group'>
        	<label for='typeAdd'>Typ</label>
            <select class='form-control' name='typeAdd'>"
			  . $optionValues .
			"</select>
            </div>
            <div class='form-group'>
        	<label for='distanceAdd'>Distans (anges i kilometer)</label>
            <input type='number' class='form-control' min='1' max='1000' name='distanceAdd' id='distanceAdd'>
            </div>
            <div class='form-group'>
        	<label for='timeAdd'>Tid</label>
			<input type='number' class='form-control time' name='hoursAdd' id='hoursAdd' min='0' max='1000'>
            <input type='number' class='form-control time' name='minutesAdd' id='minutesAdd' min='0' max='59'>
            <input type='number' class='form-control time' name='secondsAdd' id='secondsAdd' min='0' max='59'>
            </div>
            <div class='form-group'>
        	<label for='commentAdd'>Kommentar</label>
            <input type='text' rows='4' class='form-control' maxlength='255' name='commentAdd' id='commentAdd'>
            </div>
            <input type='submit' value='Lägg till' name='submitAdd' class='btn btn-default'>
            </div>
        </form>
        </div>
        </div>";
        return $html;
	}

	public function getDateAdd(){
		if (isset($_POST['dateAdd'])) {
			$this->dateAdd = $_POST['dateAdd'];
			return $this->dateAdd;
		}
		return '';
	}

	public function getTypeAdd(){
		if (isset($_POST['typeAdd]'])) {
			$this->typeAdd = $_POST['typeAdd'];
			return $this->typeAdd;
		}
		return '';
	}

	public function getDistanceAdd(){
		if (isset($_POST['distanceAdd'])) {
			$this->distanceAdd = $_POST['distanceAdd'];
			return $this->distanceAdd;
		}
		return '';
	}
	//["commentAdd"]=> string(12) "en text här" ["submitAdd"]=> string(10) "Lägg till" }
	public function getHoursAdd(){
		if (isset($_POST['hoursAdd'])) {
			$this->hoursAdd = $_POST['hoursAdd'];
			return $this->hoursAdd;
		}
		$this->hoursAdd = '00';
		return $this->hoursAdd;
	}

	public function getMinutesAdd(){
		if (isset($_POST['minutesAdd'])) {
			$this->minutesAdd = $_POST['minutesAdd'];
			return $this->minutesAdd;
		}
		$this->minutesAdd = '00';
		return $this->minutesAdd;
	}

	public function getSecondsAdd(){
		if (isset($_POST['secondsAdd'])) {
			$this->secondsAdd = $_POST['secondsAdd'];
			return $this->secondsAdd;
		}
		$this->secondsAdd = '00';
		return $this->secondsAdd;
	}

	public function getTimeAdd(){

	}

	public function getCommentAdd(){
		if (isset($_POST['commentAdd'])) {
			$this->commentAdd = $_POST['commentAdd'];
			return $this->commentAdd;
		}
		return '';
	}

	public function isFilledDistance(){
		if (isset($_POST['distanceAdd']) && !empty($_POST['distanceAdd'])) {
			return TRUE;
		}
		return FALSE;
	}

	public function isFilledMinutes(){
		if (isset($_POST['minutesAdd']) && !empty($_POST['minutesAdd'])) {
			return TRUE;
		}
		return FALSE;
	}

	public function failRequiredFields(){
		$this->message = '<p class="error">Oligatoriska fält saknas, fälten "Distans" och "minuter" måste vara ifyllda.</p>';
	}
	
}