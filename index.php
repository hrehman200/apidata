<?php
require __DIR__ . '/config.php';
?>

<?php
require_once __DIR__ . '/header.php';
?>

<div class="container-fluid mt-3 mb-5">

    <h3>Properties</h3>

    <hr />

    <p class="text-right"><b>Note:</b> Search will be done on Property Type, Town, Bedrooms, Price and Type columns only.</p>

    <div class="row">
        <div class="col-12">
            <table id="tblProperties" class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th>Img</th>
                        <th>Property Type</th>
                        <th>Address</th>
                        <th>Town</th>
                        <th>County</th>
                        <th>Country</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>Price</th>
                        <th>Type</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<script>
    $(function() {

        $('#tblProperties').DataTable({
            "searchHighlight": true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'ajax.php'
            },
            'columns': [{
                    data: 'thumbnail',
                    "render": function(data, type, row, meta) {
                        return '<img src="' + data + '" />';
                    }
                },
                {
                    data: 'property_type'
                },
                {
                    data: 'address'
                },
                {
                    data: 'town'
                },
                {
                    data: 'county'
                },
                {
                    data: 'country'
                },
                {
                    data: 'beds'
                },
                {
                    data: 'baths'
                },
                {
                    data: 'price'
                },
                {
                    data: 'type'
                },
            ]
        });
    });
</script>