<?php

$quick_search = mysqli_real_escape_string($conn, $_POST['quick_search']);

?>

<h2>Quick Search Results (Search Term: <?php echo $quick_search; ?>)</h2>

<?php
$subject_sql = "SELECT * FROM `subject_table` WHERE `Subject` LIKE '%$quick_search%'";
$subject_query = mysqli_query($conn, $subject_sql);
$subject_rs = mysqli_fetch_assoc($subject_query);

$subject_count = mysqli_num_rows($subject_query);

if ($subject_count > 0) {
    $subject_ID = $subject_rs['Subject_ID'];
}

else
{
    $subject_ID = "-1";
}
$find_sql= "SELECT * FROM `quote_table` 
JOIN author_table ON (`author_table`.`Author_ID` = `quote_table`.`Author_ID`) 
WHERE `Author` LIKE '%$quick_search%'
OR `Subject1_ID` = $subject_ID
OR `Subject2_ID` = $subject_ID
OR `Subject3_ID` = $subject_ID";

$find_query = mysqli_query($conn, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);
$count = mysqli_num_rows($find_query);

if ($count > 0){
do {
    $quote = preg_replace('/[^A-Za-z0-9.,?\s\'\-]/', ' ', $find_rs['Quote']);
    $author = $find_rs['Author']
?>

<div class="results">
    <p>
    <?php echo $quote; ?><br />
    <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID'] ?>">
    <?php echo $author; ?>
    </a>
    </p>
    <p>
        <?php
            $sub1_ID = $find_rs['Subject1_ID'];
            $sub2_ID = $find_rs['Subject2_ID'];
            $sub3_ID = $find_rs['Subject3_ID'];

            $all_subjects = array($sub1_ID, $sub2_ID, $sub3_ID);

            foreach($all_subjects as $subject) {
                $sub_sql = "SELECT * FROM `subject_table` WHERE `Subject_ID` = $subject";
                $sub_query = mysqli_query($conn, $sub_sql);
                $sub_rs = mysqli_fetch_assoc($sub_query);
                if($subject != 0) { ?>

                <span class= "tag">
                <a href="index.php?page=subject&subjectID=<?php echo $subject ?>">
                    <?php echo $sub_rs['Subject']; ?>
                </a>
                </span> &nbsp;

                <?php
                    
                }
            }

        ?>
    </p>
</div>

<br />

<?php

}

while($find_rs = mysqli_fetch_assoc($find_query));

}

else{
    ?>

    <h2>Oops!</h2>

    <div class="error">
        Sorry- there are no quotes that match the search term <i><b><?php echo $quick_search; ?></b></i>. Please try again.
    </div>

<p>&nbsp;</p>

<?php
}
?>
