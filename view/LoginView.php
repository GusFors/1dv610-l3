<?php

class LoginView
{
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $userSession;
	private $adminView;

	public function __construct(UserSession $us, AdminView $av)
	{
		$this->userSession = $us;
		$this->adminView = $av;
	}

	public function response($message): string
	{
		$response = '';
		if ($this->userSession->isLoggedIn()) {
			$response = $this->generateLogoutButtonHTML($message);

			if ($this->userSession->getUserPermissions() == LoginUser::ADMIN_PERMISSION || $this->userSession->getUserPermissions() == LoginUser::MOD_PERMISSION) {
				$response .= $this->adminView->generateAdminView();
			}
		} else {
			$response = $this->generateLoginFormHTML($message);
		}
		return $response;
	}

	private function generateLogoutButtonHTML($message): string
	{
		return '
			<form action="?" method="post" >
				<p id="' . self::$messageId . '">' . $message . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	private function generateLoginFormHTML($message): string
	{
		$storedName = $this->userSession->getStoredUsername();
		return '
			<form action="?" method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $storedName . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	public function isLoginPost(): bool
	{
		return isset($_POST[self::$login]);
	}

	public function isRemember(): bool
	{
		return isset($_POST[self::$keep]);
	}

	public function isLogoutPost(): bool
	{
		return isset($_POST[self::$logout]);
	}

	public function getRequestUsername(): string
	{
		if (isset($_POST[self::$name])) {
			return $_POST[self::$name];
		}
		return '';
	}

	public function getRequestUserPassword(): string
	{
		if (isset($_POST[self::$password])) {
			return $_POST[self::$password];
		}
		return '';
	}
}
