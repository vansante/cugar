<script type="text/javascript">
cg.mode.clickHandler = function() {
    cg.mode.load();
};

cg.mode.load = function() {
    cg.data.mode_selection = {};
    cg.data.mode1 = {};
    cg.data.mode2 = {};
    cg.data.mode2_whitelist = {};
    cg.data.mode3 = {};

    cg.doAction({
        url: 'test_xml/modes.xml',
        module: 'modes',
        page: 'get',
        error_element: [$('#mode_selection_form_error'), $('#mode_mode1_form_error'), $('#mode_mode2_form_error'), $('#mode_mode3_form_error')],
        content_id: ['cp_mode_selection', 'cp_mode_mode1', 'cp_mode_mode2', 'cp_mode_mode3'],
        successFn: function(json) {
            cg.data.mode_selection = json.modes;
            cg.data.mode1 = json.modes.mode1;
            cg.data.mode2 = json.modes.mode2;
            cg.data.mode3 = json.modes.mode3;
            
            var items = json.modes.mode2.portal.whitelist.item;
            if (items) {
                if ($.isArray(items)) {
                    $.each(items, function(i, item) {
                        cg.data.mode2_whitelist[item.value] = item.value;
                    });
                } else {
                    cg.data.mode2_whitelist[items.value] = items.value;
                }
            }

            cg.mode.loadAllForms();
        }
    });
};

cg.mode.loadAllForms = function() {
    cg.mode.selection.loadForm();
    cg.mode.mode1.loadForm();
    cg.mode.mode2.loadForm();
    cg.mode.mode2.whitelist.loadTable();
    cg.mode.mode3.loadForm();
};
</script>