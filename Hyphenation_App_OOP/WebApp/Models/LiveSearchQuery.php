<?php

require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/Database.php';
require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/QueryBuilder.php';

use Classes\Side_Functions\Database\Database;
use Classes\Side_Functions\Database\QueryBuilder;

$connection = new Database();
$select = new QueryBuilder();

if (isset($_REQUEST["term"])) {

    $param_term = $_REQUEST["term"];


    $sql = $select->select(['*'])
    ->from('pattern_table')
    ->where('id')
        ->what($param_term)
        ->getString('select');

    $result = $connection->buildWithPrepare($sql);
    $result2 = $connection->buildWithQuery($sql);

    if ($result->fetchColumn() > 0) {

        foreach ($result2 as $res ){
            ?>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th scope="col">Id</th>
                    <th scope="col">Pattern</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td><?php echo $res['id']?></td>
                    <td><?php echo $res['pattern'] ?></td>
                    <td><a href="Pattern?id=<?php echo $res['id'] ?>" class="btn btn-warning">Edit</a></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $res['id'] ?>">
                            <input type="submit" class="btn btn-danger" value="Delete" name="delete">
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>


        <?php }


    } else {
        echo "<p>No matches found</p>";


    }
}
?>