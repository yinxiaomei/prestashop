<script type="text/javascript">
    $(document).ready(function() {
        $('#black').smartpaginator({ 
            totalrecords: <?php echo $totalPage; ?>,
            recordsperpage: <?php echo $eachPage; ?>,
            datacontainer: 'lofcontent_comments_list', 
            dataelement: 'li',
            theme: 'black' 
        });
    });
</script>