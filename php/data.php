<?php
    while ($row = mysqli_fetch_assoc($sql)){
        // query for last recent msg 
        $sql1 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
        OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
        OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1 ";

        $query1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($query1);

        (mysqli_num_rows($query1) > 0 ) ? $result = $row1['msg'] : $result = "No msg go start chat 1st";

        (strlen($result) > 28 ) ? $msg = substr($result, 0, 28) . '.....': $msg = $result;

        (isset($row1['outgoing_msg_id']) && $outgoing_id == $row1['outgoing_msg_id']) ? $you = "You: " : $you = "";

        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

        $output .='<a href="chat.php?user_id='. $row['unique_id'] .'">
                      <div class="content">
                           <img src="php/images/'. $row['img'] .'" alt="">
                               <div class="details">
                                   <span>'. $row['fname']. " " . $row['lname'] .'</span>
                                   <p> '. $you . $msg.' </p>
                               </div>
                       </div> 
                       <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                   </a>';
    }
?>