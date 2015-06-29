<?php
  class RestUtils
  {
    public static function processRequest()
    {
        // get our verb
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);
        $return_obj   = new RestRequest();
      


            // basically, we read a string from PHP's special input location,
            // and then parse it out into an array via parse_str... per the PHP docs:
            // Parses str  as if it were the query string passed via a URL and sets
            // variables in the current scope.
       
            parse_str(file_get_contents('php://input'), $put_vars);
            $data = $put_vars;
     $sa = file_get_contents('php://input');

        // store the method
        $return_obj->setMethod($request_method);

        // set the raw data, so we can access it if needed (there may be
        // other pieces to your requests)
        $return_obj->setRequestVars($data);

        $return_obj->setData($sa);
        return $return_obj;
    }

    public static function sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {

      $status_header = 'HTTP/1.1 ' . $status . ' ' . RestUtils::getStatusCodeMessage($status);
      // set the status
      header($status_header);
      // set the content type
      header('Content-type: ' . $content_type);

      // pages with body are easy
      if($body != '')
      {
        // send the body
        echo json_encode($body);
        exit;
      }
      // create some body messages
      $message = '';

      // this is purely optional, but makes the pages a little nicer to read
      // for your users.  Since you won't likely send a lot of different status codes,
      // this also shouldn't be too ponderous to maintain
      switch($status)
      {
        case 401:
          $message = 'You must be authorized to view this page.';
          break;
        case 404:
          $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
          break;
        case 500:
          $message = 'The server encountered an error processing your request.';
          break;
        case 501:
          $message = 'The requested method is not implemented.';
          break;
      }

      // servers don't always have a signature turned on (this is an apache directive "ServerSignature On")
      $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

      // this should be templatized in a real-world solution
      $body = '<!DOCTYPE>
            <html>
              <head>
                <title>' . $status . ' ' . RestUtils::getStatusCodeMessage($status) . '</title>
              </head>
              <body>
                <h1>' . RestUtils::getStatusCodeMessage($status) . '</h1>
                <p>' . $message . '</p>
                <hr />
                <address>' . $signature . '</address>
              </body>
            </html>';

      echo $body;
      exit;
    }

    public static function getStatusCodeMessage($status)
    {
      // these could be stored in a .ini file and loaded
      // via parse_ini_file()... however, this will suffice
      // for an example
      $codes = Array(
          100 => 'Continue',
          101 => 'Switching Protocols',
          200 => 'OK',
          201 => 'Created',
          202 => 'Accepted',
          203 => 'Non-Authoritative Information',
          204 => 'No Content',
          205 => 'Reset Content',
          206 => 'Partial Content',
          300 => 'Multiple Choices',
          301 => 'Moved Permanently',
          302 => 'Found',
          303 => 'See Other',
          304 => 'Not Modified',
          305 => 'Use Proxy',
          306 => '(Unused)',
          307 => 'Temporary Redirect',
          400 => 'Bad Request',
          401 => 'Unauthorized',
          402 => 'Payment Required',
          403 => 'Forbidden',
          404 => 'Not Found',
          405 => 'Method Not Allowed',
          406 => 'Not Acceptable',
          407 => 'Proxy Authentication Required',
          408 => 'Request Timeout',
          409 => 'Conflict',
          410 => 'Gone',
          411 => 'Length Required',
          412 => 'Precondition Failed',
          413 => 'Request Entity Too Large',
          414 => 'Request-URI Too Long',
          415 => 'Unsupported Media Type',
          416 => 'Requested Range Not Satisfiable',
          417 => 'Expectation Failed',
          500 => 'Internal Server Error',
          501 => 'Not Implemented',
          502 => 'Bad Gateway',
          503 => 'Service Unavailable',
          504 => 'Gateway Timeout',
          505 => 'HTTP Version Not Supported'
      );

      return (isset($codes[$status])) ? $codes[$status] : '';
    }
  }


  class RestRequest
  {
    private $request_vars;
    private $data;
    private $http_accept;
    private $method;

    public function __construct()
    {
      $this->request_vars     = null;
      $this->data             = '';
      $this->http_accept      = (strpos($_SERVER['HTTP_ACCEPT'], 'json')) ? 'json' : 'xml';
      $this->method           = 'get';
    }

    public function setData($data)
    {
      $this->data = $data;
    }

    public function setMethod($method)
    {
      $this->method = $method;
    }

    public function setRequestVars($request_vars)
    {
      $this->request_vars = $request_vars;
    }

    public function getData()
    {
      return $this->data;
    }

    public function getMethod()
    {
      return $this->method;
    }

    public function getHttpAccept()
    {
      return $this->http_accept;
    }

    public function getRequestVars()
    {
      return $this->request_vars;
    }
  }

 

  $data = RestUtils::processRequest();
  if(null != $data) {
    // Create a database connection
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "Sj890905";
    $dbname = "User";
    $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   // $connection->autocommit(FALSE);
    // Test if connection succeeded
    if(mysqli_connect_errno()) {
      die("Database connection failed: " . 
           mysqli_connect_error() . 
           " (" . mysqli_connect_errno() . ")"
      );
    } 
    switch($data->getMethod())
    {
      case 'put':
        //Perform database query
        $id = $data->getRequestVars()['id'];
        $username = $data->getRequestVars()['username'];
        $active = $data->getRequestVars()['active']; 
        $password = $data->getRequestVars()['password'];   
        $query  = " u.id, u.password, un.description, u.actived ";      
        if ($result = $connection->query("SELECT un.description FROM user.user u JOIN user.user_name un ON un.id = u.user_name_id WHERE u.id = ". $id)) {
            if($subject = mysqli_fetch_assoc($result)) {
                  $curUserName = $subject["description"];
                  if($curUserName != $username) {
                      $stmt = $connection->prepare("INSERT INTO user.user_name VALUES (default, ?)");
                      $stmt->bind_param('s', $username);
                      if ($stmt->execute()) {
                          $user_name_id = $connection->insert_id;  
                          $stmt->close();                  
                          $stmt = $connection->prepare("UPDATE user.user SET user_name_id=?, password=?, actived=? WHERE id = ?");
                          $stmt->bind_param('isid', $user_name_id, $password, $active, $id);
                          if ($stmt->execute()) {
                            $stmt->close();
                            $connection->close();
                            RestUtils::sendResponse(202);          
                          } else {
                            $err = $connection->error;
                            $stmt->close();
                            $connection->close();
                            RestUtils::sendResponse(500, $err);
                          }         
                      } else {
                        $err = $connection->error;
                        $stmt->close();
                        $connection->close();
                        RestUtils::sendResponse(500, $err);
                      }
                } else {
                    $stmt = $connection->prepare("UPDATE user.user SET password=?, actived=? WHERE id = ?");
                    $stmt->bind_param('sid', $password, $active, $id);
                    if ($stmt->execute()) {
                        $stmt->close();
                        $connection->close();
                        RestUtils::sendResponse(202);          
                    } else {
                        $err = $connection->error;
                        $stmt->close();
                        $connection->close();
                        RestUtils::sendResponse(500, $err);
                    }       
                }
            }
        } else {
          $err = $connection->error;
          $stmt->close();
          $connection->close();
          RestUtils::sendResponse(500, $err);
        }      
        break;
      case 'post':
       //Perform database query
        $username = $data->getRequestVars()['username'];
        $active = $data->getRequestVars()['active']; 
        $password = $data->getRequestVars()['password'];   
        $stmt = $connection->prepare("INSERT INTO user.user_name VALUES (default, ?)");
        $stmt->bind_param('s', $username);
        if ($stmt->execute()) {
          $user_name_id = $connection->insert_id;   
          $stmt->close();               
          $stmt = $connection->prepare("INSERT INTO user.user VALUES (default, ?, ?, ?, false, null)");
          $stmt->bind_param('isi', $user_name_id, $password, $active);
          if ($stmt->execute()) {            
            $id = $connection->insert_id;
            $stmt->close();
            $connection->close();
            RestUtils::sendResponse(201, array('id' => $id), "application/json");          
          } else {
            $err = $connection->error;
            $stmt->close();
            $connection->close();
            RestUtils::sendResponse(500, $err);
          }
        
        } else {
            $err = $connection->error;
            $stmt->close();
            $connection->close();
            RestUtils::sendResponse(500, $err);
        } 
        break;
      case 'delete':
        //Perform database query
        $id = $data->getRequestVars()['id'];
        $d=date("Y/m/d");
        $stmt = $connection->prepare("UPDATE user.user SET deleted=true, date_deletion=? WHERE id = ?");
        $stmt->bind_param('si',$d, $id);
        if ($stmt->execute()) {
          $stmt->close();
          $connection->close();
          RestUtils::sendResponse(202);          
        } else {
          $err = $connection->error;
          $stmt->close();
          $connection->close();
          RestUtils::sendResponse(500, $err);
        }        
        break;
    }
    


    // Close database connection
    $connection->close();
  }

?>