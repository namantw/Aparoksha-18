<?php
session_start();
include_once 'dbconnect.php';
if(!isset($_SESSION['user'])!="")
{
	header("Location: index.php");
}
$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
$active=$userRow['active'];
if($active==0)
{
		header("Location: verify.php");
}
$q27score=$userRow['q27'];
$q28score=$userRow['q28'];
if($q27score==0)
{
	header("Location: next.php");
}
else if($q28score==10)
{
	header("Location: q28ss.php");
}


$ques=mysql_query("SELECT * FROM ques WHERE ques_id=2");
$quesRow=mysql_fetch_array($ques);
$q28=$quesRow['q_ans'];

if(isset($_POST['q28_submit']))
{
	$q28_ans = mysql_real_escape_string($_POST['q28_ans']);
	$q28_ans=trim($q28_ans);
	$q28_ans=md5($q28_ans);
	$q28_ans=trim($q28_ans);

	if($q28_ans==$q28)
	{
		$q28_score=10;
		if(mysql_query("UPDATE users SET q28=10 , score=score+10 WHERE user_id=".$_SESSION['user']))
    		{
      			?>
      			<script>alert('successfully submitted');</script>
      			<?php
			header("Location: q28ss.php");
    		}
		else
		{
			?>
      			<script>alert('query problem');</script>
      			<?php	
		}
	}
	else
	{
		
      			?>
      			<script>alert('wrong answer');</script>
      			<?php
	}	
}	
		
?>
<html>
<head>
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

<body>

  <div id="test1" class="col s12 m9 l10"><br>
	<h2> This Is q28 </h2>
        <img class="materialboxed initialized" height="400" width="650" src="images/sample-1.jpg" ><br>
	       
	<div class="row">
    <form method="post" class="col s12">
      <div class="row">
        <div class="input-field col s12 m3">
          <input placeholder="Enter text" id="q28_ans" name="q28_ans" type="text" class="validate">
          <label for="q28_ans">Answer</label>
        </div>
 <button class="btn waves-effect waves-light btn-large" type="submit" name="q28_submit">Submit
    <i class="material-icons right">send</i>
  </button>
  </div>
    </form>
  </div>


