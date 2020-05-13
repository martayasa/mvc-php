<?php

class App
{

  protected $controller = 'Home';
  protected $method = 'index';
  protected $params = [];

  public function __construct()
  {
    $url = $this->parseURL();
    // var_dump($url);

    // Controller
    if (file_exists('../app/controllers/' . $url[0] . '.php')) {
      $this->controller = $url[0];
      unset($url[0]);
    }

    require_once '../app/controllers/' . $this->controller . '.php';
    $this->controller = new $this->controller;

    // Method
    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {
        $this->method = $url[1];
        unset($url[1]);
      }
    }

    // Params (Parameter)
    if (!empty($url)) {
      $this->params = array_values($url);
    }

    // Jalankan controller & method, serta kirimkan params jika ada
    call_user_func_array([$this->controller, $this->method], $this->params);

    // echo '<br />';
    // echo "Hello Word </br>";
    // var_dump($_GET);

    // $jml = count($url);
    // echo '</p>' . 'Jumlah elemen array url = ' . $jml . '</p>';
    // for ($i = 1; $i <= $jml; $i++) {
    //   echo $url[$i] . '</br>';
    // }
  }

  public function parseURL()
  {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url'], "/");
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
  }
}
