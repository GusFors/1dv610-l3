<?php


class LayoutView
{
  private $dayTimeView;
  private $userSession;


  public function __construct(DateTimeView $dv, UserSession $userSession)
  {
    $this->dayTimeView = $dv;
    $this->userSession = $userSession;
  }

  public function render($viewToRender, string $statusMessage) // ta emot från controller statusmessage istället för grab i view
  { // protesterar den mot h1 assignment 3?
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
              ' . $viewToRender->response($statusMessage) . '
              
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
    if ($this->userSession->isLoggedIn()) {
      return '';
    } else if ($this->userSession->getCurrentpage() == Application::INDEX_PAGE) {
      return '<a href="?register">Register a new user</a>';
    } else if ($this->userSession->getCurrentpage() == Application::REGISTER_PAGE) {
      return '<a href="?">Back to login</a>';
    }
  }
}
