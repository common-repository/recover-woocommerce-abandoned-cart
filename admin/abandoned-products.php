<p></p>
<br/>


<?php
$ab_amount = $amount_graph->total_amount;
$ab_graph_data = $amount_graph->graph_data;
?>

<?php
$ab_count = $count_graph->total_count;
$abc_graph_data = $count_graph->graph_data;
?>


<?php
$cart_amount_ar = array();
foreach ($ab_graph_data as $key => $value) {
    if ($key == 0) {
        array_push($cart_amount_ar, array($value['1'], $value['2'], true, true));
    } else {

        array_push($cart_amount_ar, array($value['1'], $value['2'], false));
    }
}


$cart_count_ar = array();
foreach ($abc_graph_data as $key => $value) {
    if ($key == 0) {
        array_push($cart_count_ar, array($value['1'], $value['2'], true, true));
    } else {

        array_push($cart_count_ar, array($value['1'], $value['2'], false));
    }
}
?>


<div class="row p-4">
    <div class="col-md-6">
        <div id="chart-container"></div>
    </div>

    <div class="col-md-6">
        <div id="chart-container2"></div>
    </div>
</div>
<br/>

<style>
    @import 'https://code.highcharts.com/css/highcharts.css';

    #chart-container {
        height: 400px;
        max-width: 800px;
        min-width: 320px;
        margin: 0 auto;
    }
    #chart-container2 {
        height: 400px;
        max-width: 800px;
        min-width: 320px;
        margin: 0 auto;
    }
    .highcharts-pie-series .highcharts-point {
        stroke: #EDE;
        stroke-width: 2px;
    }
    .highcharts-pie-series .highcharts-data-label-connector {
        stroke: silver;
        stroke-dasharray: 2, 2;
        stroke-width: 2px;
    }
</style>

<script>
    Highcharts.chart('chart-container', {

        chart: {
            styledMode: true
        },

        title: {
            text: 'Abandoned Cart Revenue'
        },

        series: [{
                type: 'pie',
                allowPointSelect: true,
                keys: ['name', 'y', 'selected', 'sliced'],
                data: <?php echo json_encode($cart_amount_ar); ?>,
                showInLegend: true
            }]
    });

    Highcharts.chart('chart-container2', {

        chart: {
            styledMode: true
        },

        title: {
            text: 'Abandoned Cart Counts'
        },

        series: [{
                type: 'pie',
                allowPointSelect: true,
                keys: ['name', 'y', 'selected', 'sliced'],
                data: <?php echo json_encode($cart_count_ar); ?>,
                showInLegend: true
            }]
    });
</script>




<hr>

<div class="container">


    <div class="">
        <h3>Abandoned Cart Amount</h3>
        <p>
        <h6> Total: <?php echo $ab_amount; ?> </h6>
        </p>
        <br/>


    </div>


    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product</th>
                <th scope="col">Amount</th>
                <th scope="col">Count</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($ab_graph_data as $key => $value) { ?>

                <tr>
                    <th scope="row"><?php echo $key + 1; ?></th>
                    <td><a href="<?php echo get_permalink($value[0]); ?>"><?php echo $value[1]; ?></a></td>
                    <td><?php echo utf8_encode(get_woocommerce_currency_symbol()), $value[2]; ?></td>
                    <td><?php echo $value[3]; ?></td>
                </tr>

    <?php
}
?>

        </tbody>
    </table>
</div>



<p></p>
<br/>

<div class="container">


    <div class="">
        <h3>Abandoned Product Count</h3>
        <p>
        <h6> Total: <?php echo $ab_count; ?> </h6>
        </p>

        <br/>


    </div>


    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product</th>
                <th scope="col">Count</th>
                <th scope="col">Amount</th>
            </tr>
        </thead>
        <tbody>
<?php
//echo '<pre>';print_r($count_graph);exit;

foreach ($abc_graph_data as $key => $value) {
    ?>

                <tr>
                    <th scope="row"><?php echo $key + 1; ?></th>
                    <td><a href="<?php echo get_permalink($value[0]); ?>"><?php echo $value[1]; ?></a></td>
                    <td><?php echo $value[2]; ?></td>
                    <td><?php echo utf8_encode(get_woocommerce_currency_symbol()), $value[3]; ?></td>
                </tr>

    <?php
}
?>

        </tbody>
    </table>
</div>

