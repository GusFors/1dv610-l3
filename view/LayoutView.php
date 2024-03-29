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

  public function render($viewToRender, string $statusMessage)
  {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment L3</h1>
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

  private function renderIsLoggedIn(): string
  {
    if ($this->userSession->isLoggedIn()) {
      return '<h2>Logged in</h2>';
    } else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderNavTagOptions(): string
  {
    if ($this->userSession->isLoggedIn()) {
      return '';
    } else if ($this->userSession->getCurrentpage() == Controller::INDEX_PAGE) {
      return '<a href="?register">Register a new user</a>';
    } else if ($this->userSession->getCurrentpage() == Controller::REGISTER_PAGE) {
      return '<a href="?">Back to login</a>';
    }
  }
}
