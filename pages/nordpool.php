<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 20px;
        }

        .item {
            background: #ce8888;
            border-radius: 30px;
            padding: 20px;
            margin-top: 70px;
        }

        .sortable {
            cursor: pointer;
        }

        .sort-arrow {
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 5px;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
        }

        .asc .sort-arrow {
            border-bottom: 5px solid black;
        }

        .desc .sort-arrow {
            border-top: 5px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 3px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
            position: relative;
        }

        th:hover {
            background-color: #555;
        }

        th:hover .sort-arrow {
            opacity: 1;
        }

        .sort-arrow {
            position: absolute;
            right: 10px;
            top: 50%;
            opacity: 0.5;
            transition: opacity 0.2s ease-in-out;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container">

        <?php
        error_reporting(E_ALL);
        Function myTime(){
            return date('H:i:s');
        }
        function sortByKey(&$array, $key, $descending = false){
            usort($array, function($a, $b) use ($key, $descending){
                if($a[$key] == $b[$key]){
                    return 0;
                }
                if($descending){
                    return ($a[$key] < $b[$key] ? 1 : -1);
                }else{
                    return ($a[$key] > $b[$key] ? 1 : -1);
                }
            });
        }

        $allNordpool = json_decode(file_get_contents('https://lax.lv/nordpool2.json'), true);
        $avg = $allNordpool['averageToday'];
        $allNordpool = $allNordpool['byPriceToday'];

        $output = [];
        $timeData = array_column($output, 'time');
        $priceData = array_column($output, 'price');
        $i = 0;
        
        foreach ($allNordpool as $time => $price) {
            $hours[] = $time;
            $prices[] = $price;
            $economy = '';
            if ($i < 5) {
                $economy = 'laba cena';
            } else if ($i > 18) {
                $economy = 'slikta cena';
            } else if ($price < $avg) {
                $economy = 'videja cena';
            }
            $output[] = [
                'time' => $time,
                'price' => $price,
                'economy' => $economy
            ];
        
            $i++;
        }
        ?>

        <div class="item">
            <table border="1">

                <thead>
                    <tr>
                        <th class="sortable" data-sort="time">Stunda <span class="sort-arrow"></span></th>
                        <th class="sortable" data-sort="price">Cena <span class="sort-arrow"></span></th>
                        <th>Ekonomija</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach($output as $hour) {
                        $economy = '';
                        if($hour['price'] < 5){
                            $economy = 'laba cena';
                        }else if ($hour['price'] > 18) {
                            $economy = 'slikta cena';
                        }else if ($hour['price'] < $avg){
                            $economy = 'videja cena';
                        }
                        ?>
                        <tr>
                            <td data-key="time"> <?=$hour['time']?> </td>
                            <td data-key="price"> <?=$hour['price']?> </td>
                            <td data-key="economy" style="background-color:
                            <?php if($economy == "laba cena"){
                                echo "darkgreen";
                            }else if ($economy == "slikta cena"){
                                echo "red";
                            }else if ($economy == "videja cena"){
                                echo "lightgreen";
                            }else{
                                echo "black";
                            }?>"></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            <div class="item">
                <h1>Nordpool cenas, cents</h1>
                by time
                <div style="width: 800px; height: 405px;">
                    <canvas id="myTemperatureChart"></canvas>
                </div>

                <script>
                var ctx = document.getElementById('myTemperatureChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?=json_encode($hours)?>,
                        datasets: [
                            {
                                label: 'Price',
                                data: <?=json_encode($prices)?>,
                                backgroundColor: 'transparent',
                                borderColor: 'blue'
                            },
                            {
                                label: 'Average',
                                data: <?=json_encode(array_fill(0, count($hours), $avg))?>,
                                backgroundColor: 'transparent',
                                borderColor: 'red',
                                borderDash: [5, 5]
                            }
                        ]
                    }
                });
                </script>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ths = document.querySelectorAll('.sortable');

                ths.forEach(function (th) {
                    th.addEventListener('click', function () {
                        var sortOrder = this.classList.contains('asc') ? 'desc' : 'asc';
                        var sortKey = this.getAttribute('data-sort');

                        ths.forEach(function (th) {
                            th.classList.remove('asc', 'desc');
                        });

                        this.classList.add(sortOrder);
                        sortTable(sortKey, sortOrder);
                    });
                });

                function sortTable(sortKey, sortOrder) {
    var table = document.querySelector('table');
    var tbody = table.querySelector('tbody');
    var rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort(function (a, b) {
        var aValue = a.querySelector('td[data-key="' + sortKey + '"]').textContent;
        var bValue = b.querySelector('td[data-key="' + sortKey + '"]').textContent;

        // Convert values to numbers for numeric sorting
        if (sortKey === 'price') {
            aValue = parseFloat(aValue);
            bValue = parseFloat(bValue);
        }

        if (sortOrder === 'asc') {
            return aValue - bValue;
        } else {
            return bValue - aValue;
        }
    });

    tbody.innerHTML = '';
    rows.forEach(function (row) {
        tbody.appendChild(row);
    });
}
            });
        </script>
    </body>
</html>