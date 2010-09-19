<script type="text/javascript">
$(function(){
    $('#system_reboot_submit').click(function(){
        cg.confirm("Are you sure?", "Are you sure you want to reboot the device?", function() {
            cg.doFormAction({
                url: 'testxml/reply.xml',
                form_id: 'system_reboot_form',
                error_element: $('#system_reboot_form_error'),
                successFn: function(json) {
                    cg.rebootNotice();
                }
            });
        });
        return false;
    });
});
</script>