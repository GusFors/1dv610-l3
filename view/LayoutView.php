<?php


class LayoutView
{

  public function render($isLoggedIn, $viewToRender, DateTimeView $dtv, $isRegister = false, $statusMessage)
  {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderHomeOrRegisterTag($isRegister, $isLoggedIn) . '
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
        
          
          <div class="container">
              ' . $viewToRender->response($statusMessage, $isLoggedIn) . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  private function renderIsLoggedIn($isLoggedIn)
  {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    } else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderHomeOrRegisterTag($isRegister, $isLoggedIn)
  {
    if ($isRegister) {
      return '<a href="?">Back to login</a>';
    } else if (!$isLoggedIn) {
      return '<a href="?register">Register a new user</a>';
    } else {
      return '';
    }
  }
}
