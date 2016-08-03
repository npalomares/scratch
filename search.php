<?php 
//what term did they search?
$phrase = $_GET['phrase'];
//get all posts and comments that are similar to the query, make sure the posts are distinct
$query_search = "SELECT distinct posts.*
				FROM posts
				LEFT JOIN comments
				ON posts.post_id = comments.post_id
				WHERE posts.is_published = 1
				AND (comments.body LIKE '%".$phrase."%'
				OR posts.title LIKE '%".$phrase."%'
				OR posts.body LIKE '%".$phrase."%')
				ORDER BY posts.date DESC";
//run it	   
$result_search = mysql_query($query_search);
//check to see if anything came back from the query
if (mysql_num_rows($result_search) >= 1){
	//setup some defaults for pagination
	$perpage = 5; //number of results to show per page
	$pagenum = 1; // set the default page number
	if(isset($_GET['pagenum'])){ //if the URL contains a page number 
		$pagenum = $_GET['pagenum'];  //set the page number
	}
	
	//CALCULATIONS FOR PAGINATION
	//total results from search
	$totalhits = mysql_num_rows($result_search); 
	
	//figure out the last page in the results (number of times we can divide the results by the number of posts per page, round up to account for any remainder - so, if we find 11 posts and have 5 per page, we will need 3 pages)
	$maxPage = ceil($totalhits/$perpage); 
	
	//check to see if the user is trying to view a valid page of results
	if($pagenum <= $maxPage && $totalhits > 0){ 

		// counting the offset
		$offset = ($pagenum - 1) * $perpage;
		
		//LIMIT X, Y
		//X = which record to start at (first record is 0)
		//Y = how many records to show after that point
		$query_modified = $query_search . " LIMIT $offset, $perpage";
		
		//run the modified query
		$modresults = mysql_query($query_modified);
		
		//pagination buttons
		$next = $totalhits - ($pagenum * $perpage);
		//if there are more pages ahead, show the button
		if ($next > 0){
			if ($next > $perpage){
				$next = $perpage;
			}
			$nextpage = $pagenum + 1;
			$next = '<a class="button" name="next_page" id="next_page" href="index.php?page=search&amp;phrase='.$phrase.'&amp;pagenum='.$nextpage.'"><span>Next Page</span></a>';
		}else{ //otherwise show a disabled button
			$next = '<span class="disabled button"  id="next_page">Next Page</span>';
		}
	
		$prev = $offset - $perpage;
		//if there are previous pages to show, show a button
		if ($prev >= 0){
			$prevpage = $pagenum - 1;
			$prev = '<a class="button" name="previous_page" href="index.php?page=search&amp;phrase='.$phrase.'&amp;pagenum='.$prevpage.'" id="previous_page"><span>Previous Page</span></a>';
		}elseif($prev < 0){ //otherwise, show a disabled button
			$prev = '<span class="disabled button" id="previous_page">Previous Page</span>';
		}
		
//############## Search Result Display ##################

?>
<h2>Search Results ( <?php echo $totalhits; ?> )</h2>
<h3>Showing page <?php echo $pagenum; ?> of <?php echo $maxPage; ?></h3>
<div class="" id="search_results_list">

<?php
//show each article 
		while ($row = mysql_fetch_array($modresults)){
			
		
			$postid = $row['post_id'];
			$query_count = mysql_query("SELECT COUNT(*) AS numcomments FROM comments WHERE post_id=$postid");
			$row_count = mysql_fetch_array($query_count);
			$numcomments = $row_count['numcomments'];
			if($numcomments == 1){
					$commenttext = '1 Comment';
			}elseif($numcomments > 1){
					$commenttext = $numcomments.' Comments';
			}else{
					$commenttext = 'No Comments';
			}?>
            
			<div class="post">
            <h3><a href="?page=single&amp;post_id=<?php echo $postid; ?>"><?php echo $row['title']; ?></a></h3>
            <div class="metadata">Posted on <?php echo convert_date($row['date']); ?> | <?php echo $commenttext; ?></div>
        </div>	
        <?php } ?>
<?php
//end while, show footer
//end search results
?>
</div>

<div class="search_div_bot">
<span class="search_div_left">Showing page <?php echo $pagenum; ?> of <?php echo $maxPage; ?></span>
<span class="search_div_right"><?php echo $prev; ?> <?php echo $next; ?></span>
</div>
<?php 
		

//##############  ERRORS  ##################

	}else{ //Uh oh, we went past the last page
		echo '<div class="comment_message">
			<span class="search_message">Page Limit Reached</span><p>
			You have gone beyond the available results limit for this search. In other words, there are no more results to see, try your search again.</div>';
	}
	
}else{ //No results to show
	echo '<div class="comment_message">
			<span class="search_message">No Matches Found</span><p>
			Try your search with a different phrase. This one turned up no results.</div>';
}
?>