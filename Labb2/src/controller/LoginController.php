<?php
namespace controller;

require_once("src/view/LoginView.php");
require_once("src/model/LoginModel.php");

class LoginController {

	private $loginView;
	private $loginModel;

	public function __construct(){
		$this->loginView = new \view\LoginView();
		$this->loginModel = new \model\loginModel();
	}

	public function doControll(){
			//varaibler för loginscenarion
			$status = "";
			$body;
			$messages = "";
			$datetime = $this->loginView->getDateAndTime();

			//hantering loginscenarion
			//scenario - användaren är redan inloggad
			if ($this->loginView->getCookieName() != NULL && $this->loginView->getCoookiePassword() != NULL) {
				$body = $this->loginView->loggedInPage();
				$status = "välkommen tillbaka!";
				//kontroll om användaren tryck på logout
				if ($this->loginView->triedToLogout() == TRUE) {
					$this->loginView->removeCookie($this->loginView->getName(), $this->loginView->getPassword());
					$this->loginModel->doLogout();
					$status = "";
					$body = $this->loginView->doLoginPage();
				}
			} 
			//scenario - användaren är inte inloggad
			else {
				$status = "Ej inloggad";
				$body = $this->loginView->doLoginPage();
				$datetime = $this->loginView->getDateAndTime();
				//scenario - användaren har tryck på "Logga in"
				if ($this->loginView->triedToLogin() === TRUE) {
					//kontroll av inloggningsuppgifter
					if ($this->loginModel->doLogin($this->loginView->getName(), $this->loginView->getPassword())) {
						//sätt eventuella kakor
						if ($this->loginView->checkBox() == TRUE) {
							$encryptedString = $this->loginView->createCookie($this->loginView->getName(), $this->loginView->getPassword());
							$status = "Inloggad";
							$messages = "Du är inloggad och vi kommer ihåg dig nästa gång";
						}
						$this->loginModel->isLoggedIn();
						$status = "Inloggad";
					}
					else{
						$status = "Fel användarnamn eller lösenord, försök igen";
					}
				} 
			}
			//scenario - användaren är nu inloggad
			if ($this->loginModel->isLoggedIn() == TRUE) {
				$body = $this->loginView->loggedInPage();
				//kontroll om användaren tryckt på logout
				if ($this->loginView->triedToLogout() == TRUE) {
					$this->loginModel->doLogout();
					$this->loginView->removeCookie($this->loginView->getName(), $this->loginView->getPassword());
					$body = $this->loginView->doLoginPage();
				}
			}
			return  $status . $messages . $body . $datetime;
	}
}