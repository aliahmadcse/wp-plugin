<style>
    table {
        font-size: 16px;
    }
</style>

<?php

function assignment_list_lectures()
{
    global $wpdb;
    //global $pluginPath;
?>
    <h1> Lectures Data List </h1>

    <?php
    $result = $wpdb->get_results('SELECT * FROM wp_lecture_description');
    ?>
    <table style="border-collapse:collapse;border:1px solid black">
        <tr>
            <th style="border:1px solid black">Title</th>
            <th style="border:1px solid black">Description</th>
        </tr>
        <?php
        foreach ($result as $key => $row) {
        ?>
            <tr>
                <td style="border:1px solid black"> <?php echo $row->title ?> </td>
                <td style="border:1px solid black"> <?php echo $row->description ?> </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <?php
}


function assignment_add_lecture()
{
    global $wpdb;

    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $wpdb->query("INSERT INTO wp_lecture_description (title,description) 
        VALUES ( '$title',  '$description') ");
        echo '<h1>Lecture Saved</h1';
    } else {
    ?>
        <div style="margin: 30px 0px 0px 100px;">
            <h4> Add a lecture </h4>
            <div>
                <form action='' method='post'>
                    <label for="title">Lecture Title</label><br>
                    <input type="text" id="title" name="title"><br>
                    <label for="description">Lecture Description:</label><br>
                    <textarea id="description" name="description" rows="5" cols="50"></textarea>
                    <div style="margin-top:10px">
                        <input type="submit" value='Submit' id='submit' name='submit'>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
