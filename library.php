<?php
    require_once("conn.php");

    
    if (array_key_exists("publisher", $_GET)) {
        header("Content-Type: text/html");
        $stm = "
SELECT l.id_book, l.name, DATE_FORMAT(l.publication_date, '%Y'), l.quantity, l.ISBN, r.title
    FROM literature l 
    LEFT JOIN resourse r ON r.id=l.fid_resourse
    WHERE l.publisher LIKE ? AND l.type LIKE 'Book';";

                $stm2 = "
SELECT * FROM book_authors ba 
    INNER JOIN authors a ON a.id=ba.fid_authors
    WHERE ba.fid_book=?;";

                $pdo_stm = $pdo->prepare($stm);
                $pdo_stm->execute(
                    array($_GET['publisher'])
                );

                $pdo_stm2 = $pdo->prepare($stm2);

                $pdo_stm->setFetchMode(PDO::FETCH_NUM);
                foreach ($pdo_stm as $row) {
                    $book_id = $row[0];
                    echo '<tr>';
                    for ($i = 1; $i <= 4; ++$i) {
                        echo '<td>' . $row[$i] . '</td>';
                    }

                    echo "<td>";
                    $pdo_stm2->execute(
                        array($book_id)
                    );
                    foreach ($pdo_stm2 as $row2) { 
                        echo $row2['name'] . ' ';
                    }
                    echo "</td>";

                    echo "<td>" . $row[5] . "</td>";

                    echo '</tr>';
                }
    } else if (array_key_exists("from", $_GET)
                && array_key_exists("to", $_GET)) {
            header('Content-Type: text/xml');
            header("Cache-Control: no-cache, must-revalidate");
            echo '<?xml version="1.0" encoding="utf8" ?>';
            echo "<root>";
            
            $stm = "
SELECT name, publication_date, publisher, quantity, ISBN, type 
    FROM literature 
    WHERE publication_date BETWEEN ? AND ?
    ORDER BY publication_date";

                $pdo_stm = $pdo->prepare($stm);
                $pdo_stm->setFetchMode(PDO::FETCH_NUM);
                $pdo_stm->execute(
                    array($_GET['from'], $_GET['to'])
                );
                foreach ($pdo_stm as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }

            echo "</root>";
            
    } else if (array_key_exists("auth_id", $_GET)) {
                        $stm = "
SELECT l.name, DATE_FORMAT(l.publication_date, '%Y') year, l.quantity, l.ISBN, r.title
    FROM book_authors ba
    INNER JOIN literature l ON l.id_book=ba.fid_book
    LEFT JOIN resourse r ON r.id=l.fid_resourse
    WHERE ba.fid_authors=? AND l.type LIKE 'Book';";

                $pdo_stm = $pdo->prepare($stm);
                $pdo_stm->setFetchMode(PDO::FETCH_ASSOC);
                $pdo_stm->execute(
                    array($_GET['auth_id'])
                );
                echo json_encode( $pdo_stm->fetchAll());
    }
