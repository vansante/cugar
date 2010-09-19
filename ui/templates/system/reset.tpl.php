<script type="text/javascript">
$(function(){
    $('#system_reset_submit').click(function(){
        cg.confirm("Are you sure?", "Are you sure you want to reset the device?", function() {
            cg.doFormAction({
                form_id: 'system_reset_form',
                error_element: $('#system_reset_form_error'),
                successFn: function(json) {
                    cg.rebootNotice();
                }
            });
        });
        return false;
    });
});
</script>