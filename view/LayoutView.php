<?php


class LayoutView
{
  private $dayTimeView;
  private $userSession;
  private static $registerPage = 'register';
  private static $indexPage = 'index';

  public function __construct(DateTimeView $dv, UserSession $userSession)
  {
    $this->dayTimeView = $dv;
    $this->userSession = $userSession;
  }

  public function render($viewToRender, string $statusMessage, string $storedName = '')
  {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderNavTagOptions() . '
          ' . $this->renderIsLoggedIn() . '
        
          
          <div class="container">
              ' . $viewToRender->response($statusMessage, $storedName) . '
              
              ' . $this->dayTimeView->show() . '
          </div>
         </body>
      </html>
    ';
  }

  private function renderIsLoggedIn()
  {
    if ($this->userSession->isLoggedIn()) {
      return '<h2>Logged in</h2>';
    } else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderNavTagOptions()
  {
    if ($this->userSession->getCurrentpage() == self::$indexPage) {
      return '<a href="?register">Register a new user</a>';
    } else if ($this->userSession->getCurrentpage() == self::$registerPage) {
      return '<a href="?">Back to login</a>';
    }
  }
}
