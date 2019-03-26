<?php

  // USERS

  function find_all_users() {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY id ASC";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_user_by_id($id) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
    // echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user; // returns an assoc. array
  }

  function find_user_by_email($email) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' ";
    $sql .= "LIMIT 1";
    // echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user;
  }

  function validate_user($user) {
    $errors = [];

    // first_name
    if(is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank";
    } elseif(!has_length($user['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Name must be between 2 and 255 characters.";
    }

    // last_name
    if(is_blank($user['last_name'])) {
        $errors[] = "Last name cannot be blank";
      } elseif(!has_length($user['last_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
      }

    // email
    if(!has_valid_email_format($user['email'])) {
        $errors[] = "Must be a valid email format - name@domain.com";
      }

    // street
    if(is_blank($user['street'])) {
        $errors[] = "Street cannot be blank";
      } elseif(!has_length($user['street'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Street must be between 2 and 255 characters.";
      }

    // town
    if(is_blank($user['town'])) {
        $errors[] = "Town cannot be blank";
      } elseif(!has_length($user['first_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Town must be between 2 and 255 characters.";
      }

    // City
    if(is_blank($user['city'])) {
        $errors[] = "City cannot be blank";
      } elseif(!has_length($user['city'], ['min' => 2, 'max' => 255])) {
        $errors[] = "City must be between 2 and 255 characters.";
      }
    
    // Postcode
    if(is_blank($user['first_name'])) {
      $errors[] = "Postcode cannot be blank";
    } elseif(!has_length($user['first_name'], ['min' => 2, 'max' => 8])) {
      $errors[] = "Postcode must be between 2 and 8 characters.";
    }
    // Password
    if(is_blank($user['password1'])) {
      $errors[] = "Password cannot be blank";
    } elseif(!has_length($user['password1'], ['min' => 8, 'max' => 255])) {
      $errors[] = "Password must be between 8 and 255 characters.";
    }
    if(is_blank($user['password2'])) {
      $errors[] = "You need to confirm your password";
    } elseif(!has_length($user['password1'], ['min' => 8, 'max' => 255])) {
      $errors[] = "Password must be between 8 and 255 characters.";
    }
    // Password1 matches Password2
    if(!password_match($user['password1'],$user['password2'])){
      $errors[] = "Passwords did not match";
    }

    return $errors;
  }

  function validate_login($email,$password){
    global $db;

    if(!is_blank($email)){
      $e = mysqli_real_escape_string($db, $email);
    } else {
      $e = FALSE;
      echo '<p class="text-danger">Please enter your email address</p>';
    }
  
    if(!is_blank($password)){
      $p = mysqli_real_escape_string($db, $password);
    } else {
      $p = FALSE;
      echo '<p class="text-danger">Please enter your password</p>';
    }
  
    if($e && $p){
      $sql = "SELECT id, password, first_name, email FROM users WHERE (email='$e')";
      $result = mysqli_query($db,$sql) or trigger_error("Query: $sql\n<br/>MySQL Error:" . mysqli_error($db));
  
      if(mysqli_num_rows($result) == 1){
        $_SESSION = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        $hash = $_SESSION['password'];
  
      if(password_verify($p, $hash)){
        echo "logged in!";
        redirect_to(url_for('/client/index.php'));
        exit();
      }
      else{
        echo '<p class="text-danger">The password entered was incorrect, or you have not registered</p>';
        unset($_SESSION);
      }
      }
      else{
        echo '<p class="text-danger">Email and Password do not match, please try again or register</p>';
      }
    }
    else{
      echo '<p class="text-danger">You did not enter an email and password</p>';
    }
  }

  function insert_user($user) {
    global $db;

    $errors = validate_user($user);
    if(!empty($errors)) {
      return $errors;
    }

    $password_encrypted = password_hash ($user['password1'], PASSWORD_DEFAULT);
    $registered = date('Y-m-d H:i:s');

    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, street, town, city, postcode, password, registered) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['first_name']) . "',";
    $sql .= "'" . db_escape($db, $user['last_name']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['street']) . "',";
    $sql .= "'" . db_escape($db, $user['town']) . "',";
    $sql .= "'" . db_escape($db, $user['city']) . "',";
    $sql .= "'" . db_escape($db, $user['postcode']) . "',";
    $sql .= "'" . db_escape($db, $password_encrypted) . "',";
    $sql .= "'" . db_escape($db, $registered) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_user($user) {
    global $db;

    $errors = validate_user($user);
    if(!empty($errors)) {
      return $errors;
    }

    $password_encrypted = password_hash ($user['password1'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET ";
    $sql .= "first_name='" . db_escape($db, $user['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $user['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $user['email']) . "', ";
    $sql .= "street='" . db_escape($db, $user['street']) . "', ";
    $sql .= "town='" . db_escape($db, $user['town']) . "', ";
    $sql .= "city='" . db_escape($db, $user['city']) . "', ";
    $sql .= "postcode='" . db_escape($db, $user['postcode']) . "', ";
    $sql .= "password='" . db_escape($db, $password_encrypted) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $_SESSION['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }

  function delete_user($id) {
    global $db;

    $sql = "DELETE FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  // events... TBC

  function find_all_events() {
    global $db;

    $sql = "SELECT * FROM events ";
    $sql .= "ORDER BY id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_event_by_user_id($user) {
    global $db;

    $sql = "SELECT * FROM events ";
    $sql .= "WHERE subject_id='" . db_escape($db, $user) . "' ";
    $sql .= "ORDER BY id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
  }

  function find_event_by_id($id) {
    global $db;

    $sql = "SELECT * FROM events ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $events = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $events; // returns an assoc. array
  }

  function validate_event($event) {
    $errors = [];

    // Event_name
    if(is_blank($event['event_name'])) {
      $errors[] = "Event name cannot be blank.";
    }

    return $errors;
  }

  function insert_event($event) {
    global $db;

    $errors = validate_event($event);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO events ";
    $sql .= "(event_name) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $event['event_name']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_event($event) {
    global $db;

    $errors = validate_event($event);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE events SET ";
    $sql .= "event_name='" . db_escape($db, $event['event_name']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $event['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }

  function delete_event($id) {
    global $db;

    $sql = "DELETE FROM events ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }


  // ADMINS

function find_all_admins() {
  global $db;

  $sql = "SELECT * FROM admins ";
  $sql .= "ORDER BY id ASC";
  //echo $sql;
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_admin_by_id($id) {
  global $db;

  $sql = "SELECT * FROM admins ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "'";
  // echo $sql;
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $user = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $user; // returns an assoc. array
}

function find_admin_by_email($email) {
  global $db;

  $sql = "SELECT * FROM admins ";
  $sql .= "WHERE email='" . db_escape($db, $email) . "' ";
  $sql .= "LIMIT 1";
  // echo $sql;
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $user = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $user;
}

function validate_admin($admin) {
  $errors = [];

  // email
  if(!has_valid_email_format($admin['email'])) {
      $errors[] = "Must be a valid email format - name@domain.com";
    }
  // Password
  if(is_blank($admin['password1'])) {
    $errors[] = "Password cannot be blank";
  } elseif(!has_length($admin['password1'], ['min' => 8, 'max' => 255])) {
    $errors[] = "Password must be between 8 and 255 characters.";
  }
  if(is_blank($admin['password2'])) {
    $errors[] = "You need to confirm your password";
  } elseif(!has_length($admin['password1'], ['min' => 8, 'max' => 255])) {
    $errors[] = "Password must be between 8 and 255 characters.";
  }
  // Password1 matches Password2
  if(!password_match($admin['password1'],$admin['password2'])){
    $errors[] = "Passwords did not match";
  }

  return $errors;
}

function validate_admin_login($email,$password){
  global $db;

  if(!is_blank($email)){
    $e = mysqli_real_escape_string($db, $email);
  } else {
    $e = FALSE;
    echo '<p class="text-danger">Please enter your email address</p>';
  }

  if(!is_blank($password)){
    $p = mysqli_real_escape_string($db, $password);
  } else {
    $p = FALSE;
    echo '<p class="text-danger">Please enter your password</p>';
  }

  if($e && $p){
    $sql = "SELECT id, password, first_name, email FROM users WHERE (email='$e')";
    $result = mysqli_query($db,$sql) or trigger_error("Query: $sql\n<br/>MySQL Error:" . mysqli_error($db));

    if(mysqli_num_rows($result) == 1){
      $_SESSION = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      $hash = $_SESSION['password'];

    if(password_verify($p, $hash)){
      echo "logged in!";
      redirect_to(url_for('/client/index.php'));
      exit();
    }
    else{
      echo '<p class="text-danger">The password entered was incorrect, or you have not registered</p>';
      unset($_SESSION);
    }
    }
    else{
      echo '<p class="text-danger">Email and Password do not match, please try again or register</p>';
    }
  }
  else{
    echo '<p class="text-danger">You did not enter an email and password</p>';
  }
}

function insert_admin($admin) {
  global $db;

  $errors = validate_admin($admin);
  if(!empty($errors)) {
    return $errors;
  }

  $password_encrypted = password_hash ($admin['password1'], PASSWORD_DEFAULT);
  $registered = date('Y-m-d H:i:s');

  $sql = "INSERT INTO admins ";
  $sql .= "(email, password, registered) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $admin['email']) . "',";
  $sql .= "'" . db_escape($db, $password_encrypted) . "',";
  $sql .= "'" . db_escape($db, $registered) . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);
  // For INSERT statements, $result is true/false
  if($result) {
    return true;
  } else {
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function update_admin($admin) {
  global $db;

  $errors = validate_admin($admin);
  if(!empty($errors)) {
    return $errors;
  }

  $password_encrypted = password_hash ($admin['password1'], PASSWORD_DEFAULT);

  $sql = "UPDATE admins SET ";
  $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
  $sql .= "password='" . db_escape($db, $password_encrypted) . "' ";
  $sql .= "WHERE id='" . db_escape($db, $_SESSION['admin_id']) . "' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  // For UPDATE statements, $result is true/false
  if($result) {
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }

}

function delete_admin($id) {
  global $db;

  $sql = "DELETE FROM admins ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);

  // For DELETE statements, $result is true/false
  if($result) {
    return true;
  } else {
    // DELETE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

// EVENTS

function find_user_events_by_id($id){
  global $db;

  $sql = "SELECT u.first_name, u.last_name, e.event_name, ue.event_date, ue.result ";
  $sql .= "FROM users as u INNER JOIN user_events as ue ";
  $sql .= "ON u.id = ue.user_id ";
  $sql .= "INNER JOIN events as e ";
  $sql .= "ON e.id = ue.event_id ";
  $sql .= "WHERE user_id='" . $id . "' ";
  $sql .= "ORDER by e.event_name ASC, ue.event_date DESC";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // returns an assoc. array
}

function find_all_user_events(){
  global $db;

  $sql = "SELECT u.first_name, u.last_name, e.event_name, ue.event_date, ue.result ";
  $sql .= "FROM users as u INNER JOIN user_events as ue ";
  $sql .= "ON u.id = ue.user_id ";
  $sql .= "INNER JOIN events as e ";
  $sql .= "ON e.id = ue.event_id ";
  $sql .= "ORDER by event_date DESC, event_name ASC, ue.result DESC";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // returns an assoc. array
}
?>