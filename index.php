<?php
$file = 'report.txt';

$lines = file($file, FILE_IGNORE_NEW_LINES);

$header = array_shift($lines);

$header = str_replace("\t", "", $header);
$header = explode(",", $header);

$rows = array();

foreach ($lines as $line) {
    $row = explode(",", $line);
    $row = array_combine($header, $row);
    $rows[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Rio Tri Prayogo">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>

    <main>

        <div class="container-fluid mt-3">
            <h1 class="text-center">Sales</h1>

            <div class="d-flex">
                <div class="row">
                    <br>
                    <form action="" method="POST">
                        <label for="filter-day" class="mb-2 fs-4">Filter Based On Day:</label>
                        <div class="row">
                            <div class="col-6">
                                <select class="form-select" name="filter-day" id="filter-day">
                                    <option value="">All Day</option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <input class="btn btn-primary" type="submit" name="filter" value="Filter">
                            </div>
                    </form>
                </div>
                <form action="" method="POST" class="my-3">
                    <button type="submit" class="btn btn-success" name="highestsales" value="Highest Sales">Highest Sales</button>
                    <button type="submit" class="btn btn-danger" name="lowestsales" value="Lowest Sales">Lowest Sales</button>
                    <button type="submit" class="btn btn-success" name="highestvisit" value="Highest Visitors">Highest Visitors</button>
                    <button type="submit" class="btn btn-danger" name="lowestvisit" value="Lowest Visitors">Lowest Visitors</button>
                </form>
            </div>
        </div>


        <?php

        if (isset($_POST['highestsales'])) {
            $sort = array_column($rows, 'sales');
            array_multisort($sort, SORT_DESC, $rows);
            echo "<h2 class='my-2'>Highest Sales</h2>";
        } elseif (isset($_POST['lowestsales'])) {
            $sort = array_column($rows, 'sales');
            array_multisort($sort, SORT_ASC, $rows);
            echo "<h2 class='my-2'>Lowest Sales</h2>";
        } elseif (isset($_POST['highestvisit'])) {
            $sort = array_column($rows, 'visitors');
            array_multisort($sort, SORT_DESC, $rows);
            echo "<h2 class='my-2'>Highest Visitors</h2>";
        } elseif (isset($_POST['lowestvisit'])) {
            $sort = array_column($rows, 'visitors');
            array_multisort($sort, SORT_ASC, $rows);
            echo "<h2 class='my-2'>Lowest Visitors</h2>";
        } elseif (isset($_POST['filter']) && ($_POST['filter-day'] != '')) {
            $filter = $_POST['filter-day'];
            $rows = array_filter($rows, function ($row) use ($filter) {
                return $row['day'] == $filter;
            });
        }

        echo "<table class='table table-bordered'>";
        echo "<thead class='table-dark'><tr>
                <th>Day</th>
                <th>Visitors</th>
                <th>Sales</th>
                ";
        echo "</tr></thead>";
        echo "<tbody>";
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($header as $col) {
                echo "<td>{$row[$col]}</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        ?>

        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>

</html>