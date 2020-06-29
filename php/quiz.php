<?php

function assignment_quiz_dropdown()
{
    global $wpdb;
    $homeURI = get_home_url();
?>
    <h2> Select a quiz to inspect result </h2>
    <form action='<?php echo $homeURI; ?>/list/' method='post'>

        <?php

        $qry = 'SELECT * FROM wp_watu_master order by ID';
        $result = $wpdb->get_results($qry);
        ?>
        <select name='quizId' id='quizId'>
            <option value='' disabled selected>Select</option>
            <?php
            foreach ($result as $key => $row) {
            ?>
                <option value="<?php echo $row->ID ?>"> <?php echo $row->name ?></option>
            <?php
            }
            ?>

            <input style="margin-left: 10px;" type='submit' vaue='Resut' class='btn btn-primary btn-lg'>

        </select>

        </from>
    <?php
}


function assignment_display_result()
{
    if (!isset($_POST['quizId'])) {
        return;
    }
    global $wpdb;
    $quizId    = $_POST['quizId'];
    $row = $wpdb->get_row('SELECT * FROM wp_watu_master WHERE ID =' . $quizId);
    ?>
        <h3>Quiz title :<?php echo $row->name; ?></h3>


        <?php
        $result = $wpdb->get_results('SELECT * FROM wp_watu_takings WHERE exam_id =' . $quizId);
        ?>
        <table class='table table-hover'>
            <tr>
                <th>Student Name</th>
                <th>Points</th>
            </tr>
            <?php
            foreach ($result as $key => $row) {
                $user = $wpdb->get_row('SELECT * FROM wp_users WHERE ID =' . $row->user_id);
            ?>
                <tr>
                    <td><?php echo $user->user_nicename ?></td>
                    <td><?php echo $row->points ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    <?php
}
