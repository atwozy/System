<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "jcra-sining";

	if($conn = new Mysqli($host, $user, $pass, $dbname)){
			$date = time();

			$sql = "SELECT * FROM sining_posts ORDER BY postId DESC";
			if($select_stat = $conn->query($sql)){
				while($post = $select_stat->fetch_assoc()){
					$post_username = $post['postUsername'];
					$post_image = $post['postImage'];
					$post_time = $post['postAtime'];
					$post_date = $post['postAdate'];
					$post_caption = $post['postCaption'];
					$post_profile = $post['postProfile'];
					$curr_time = time();
					$real_time = $curr_time - $post_time;
					$real_min = $real_time / 60;
					if($real_min < 1){
						$time_string = $real_time." seconds ago";
					}else if($real_min >= 1 && $real_min < 60){
						$time_string = round($real_min)." minutes ago";
					}else if($real_min >= 60 && $real_min < 1440){
						$hrs = $real_min / 60;
						if(round($hrs == 1)){
							$time_string = round($hrs)." hour ago";
						}else{
							$time_string = round($hrs)." hours ago";	
						}
					}else if($real_min >=1440 && $real_min < 4320){
						$days = $real_min / 1440;
						if(round($days == 1)){	
							$time_string = round($days)." day ago";
						}else{
							$time_string = round($days)." days ago";
						}	
					}else{
						$time_string=date_create($post_date);
						$time_string=date_format($time_string,"F d h:ia");
					}
					echo '
						<div class="card">
						<h2><img src="img/'.$post_profile.'" width="35px" height="35px" style="border-radius: 50%" alt=""/>'.$post_username.'</h2>
						<p class="tiem">'.$time_string.'<i class="fa fa-calendar-o"></i></p>
									<p>'.$post_caption.'</p>
					
						<img src="img/'.$post_image.'"width="100%" height="auto" alt=""/>
						</div>';

				}
			}else{
				echo "ERROR: ".$conn->error;
			}
		
	}else{
		echo "somethings wrong guys";
	}
?>