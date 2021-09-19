<h2>All Results</h2>

<?php

$find_sql= "SELECT * FROM `quote_table` JOIN author_table ON (`author_table`.`Author_ID` = `quote_table`.`Author_ID`)";

$find_query = mysqli_query($conn, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

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

while($find_rs = mysqli_fetch_assoc($find_query))

?>