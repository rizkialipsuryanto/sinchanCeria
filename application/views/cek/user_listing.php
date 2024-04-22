<!-- views/user_listing.php -->
<html>

<head>
    <title>Paging Example-User Listing</title>
</head>

<body>
    <div class="container">
        <h1 id='form_head'>User Listing</h1>

        <?php
        print '$page   : ' . $page;

        echo "<br>";
        print '$total_records   : ' . $total_records;
        if (isset($results)) { ?>
            <table border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <th>num</th>
                    <th>id</th>
                    <th>pjka</th>
                    <th>nama</th>
                </tr>

                <?php
                $no = 0;
                $page = $page / 10;
                foreach ($results as $data) { ?>
                    <tr>
                        <td><?php

                            $no = ($no + 1);
                            if ($page == 0) {
                                $hal = 0;
                            } else {
                                $hal = $page - 1;
                            }

                            //$no++;
                            echo ($hal * 10) + $no;
                            //echo $hal;
                            ?></td>
                        <td><?php echo $data->id ?></td>
                        <td><?php echo $data->NOMR ?></td>
                        <td><?php echo $data->NAMA ?></td>
                    </tr>
                <?php

            } ?>
            </table>
        <?php } else { ?>
            <div>No user(s) found.</div>
        <?php } ?>

        <?php if (isset($links)) { ?>
            <?php echo $links ?>
        <?php } ?>
    </div>
</body>

</html>