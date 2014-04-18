<?
  $temp_email = strtolower($_POST['email']);
  $validEmail = true;
  function valid_dot_pos($email) 
  { 
     $str_len = strlen($email); 
     for($i=0; $i<$str_len; $i++) 
     { 
         $current_element = $email[$i]; 
         if ($current_element == "." && ($email[$i+1] == ".")) 
         { 
             return false; 
             break; 
         } 
         else 
         { 
  
         } 
     } 
     return true; 
  } 
  function valid_local_part($local_part) 
  { 
     if (preg_match("/[^a-zA-Z0-9-_@.!#$%&'*\/+=?^`{\|}~]/", $local_part)) 
     { 
         return false; 
     } 
     else 
     { 
         return true; 
     } 
  } 
  function valid_domain_part($domain_part) 
  { 
     if (preg_match("/[^a-zA-Z0-9@#\[\].]/", $domain_part)) 
     { 
         return false; 
     } 
     elseif (preg_match("/[@]/", $domain_part) && preg_match("/[#]/", $domain_part)) 
     { 
         return false; 
     } 
     elseif (preg_match("/[\[]/", $domain_part) || preg_match("/[\]]/", $domain_part)) 
     { 
         $dot_pos = strrpos($domain_part, "."); 
         if(($dot_pos < strrpos($domain_part, "]")) || (strrpos($domain_part, "]") < strrpos($domain_part, "["))) 
         { 
             return true; 
         } 
         elseif (preg_match("/[^0-9.]/", $domain_part)) 
         { 
             return false; 
         } 
         else 
         { 
             return false; 
         } 
     } 
     else 
     { 
         return true; 
     } 
  } 
  $email = strtolower($_POST['email']);
  $allowDuplicates = 0;
  if ((isset($_POST['allowDuplicates'])) && ($_POST['allowDuplicates'] == 'true'))
  {
    $allowDuplicates = 1;
  }
  $query = $this->EE->db->query("SELECT member_id FROM exp_members WHERE LOWER(email) = '$email' LIMIT 1");
  if (($query->num_rows() > 0) && ($allowDuplicates != 1))
  {
    foreach($query->result_array() as $row)
    {
      $response = 'The email address you entered already exists.';
    }
  }
  else
  {
    $str_trimmed = trim($temp_email); 
    $at_pos = strrpos($str_trimmed, "@"); 
    $dot_pos = strrpos($str_trimmed, "."); 
    $local_part = substr($str_trimmed, 0, $at_pos); 
    $domain_part = substr($str_trimmed, $at_pos); 
    if(!isset($str_trimmed) || is_null($str_trimmed) || empty($str_trimmed) || $str_trimmed == "") 
    { 
      $validEmail = false;
    } 
    elseif (!valid_local_part($local_part)) 
    { 
      $validEmail = false;
    } 
    elseif (!valid_domain_part($domain_part)) 
    { 
      $validEmail = false;
    } 
    elseif ($at_pos > $dot_pos) 
    { 
      $validEmail = false;
    } 
    elseif (!valid_local_part($local_part)) 
    { 
      $validEmail = false;
    } 
    elseif (($str_trimmed[$at_pos + 1]) == ".") 
    { 
      $validEmail = false;
    } 
    elseif (!preg_match("/[(@)]/", $str_trimmed) || !preg_match("/[(.)]/", $str_trimmed)) 
    { 
      $validEmail = false;
    } 
    else 
    { 
      $validEmail = true;
    }   
    if ($validEmail === true)
    {
      $response = 'success';
    }
    else
    {
      $response = 'The email address does not appear to be valid';
    }
  }
    
?>