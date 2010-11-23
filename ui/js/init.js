/***************************************
****************************************
 * init.js
 *
 * @desc Initialisatie van javascript
 */

/* Initialize tabset */
$(function() {
    $('.tabset').tabs();

    //Initialize the click handlers to make the menu work.
    $('#menu li.page_link a').click(function() {
        // Open the right panel
        $('.page').hide();
        $('a.active').removeClass('active');
        var contentpart = $('#cp_'+$(this).attr('id'));
        $(this).addClass('active');
        // Initialize a hook method

        // Show the right panel
        contentpart.show();
        contentpart.parent().show();

        var url = $(this).attr('rel');
        if (cg[url] && cg[url].clickHandler) {
            cg[url].clickHandler();
        }
    });

    // Initialize a page when it's opened by an anchor
    var hash = self.document.location.hash;
    if (hash.length > 2) {
        var anchor = $(self.document.location.hash);
        if (anchor.attr('rel')) {
            var contentpart = $('#cp_'+anchor.attr('id'));
            $(anchor).addClass('active');
            // Initialize a hook method

            var url = anchor.attr('rel');

            //Toon het paneel
            contentpart.show();
            contentpart.parent().show();

            if (cg[url] && cg[url].clickHandler) {
                cg[url].clickHandler();
            }
        } else if (cg.basic) {
            cg.showHomepage();
        }
    } else if (cg.basic) {
        cg.showHomepage();
    }

    // Build help icons
    $('label').each(function() {
        var helpElement = $('#help_'+$(this).attr('for'));
        //Check if help text extists
        if (helpElement.length == 1) {
            //Give the help a header
            helpElement.prepend('<h3>Help</h3>').addClass('hidden');

            //DT to display help in
            $('<dt />')
                .insertBefore($(this).parent())
                .css('width', '100%')
                .css('padding', '0')
                .append(helpElement);

            var helpHoverElement = $('<div class="help_hover" id="'+helpElement.attr('id')+'_hover">'+helpElement.html()+'</div>');
            helpHoverElement.insertAfter($('#help_hover_pool'));

            //Build the link to open/close help
            var helpLink = $('<a href="#" class="open_help"/>');
            helpLink.click(function() {
                helpHoverElement.hide();
                helpElement.slideToggle();
                helpElement.toggleClass('hidden');
                $(this).parent().toggleClass('noborder');
            });
            helpLink.mouseover(function() {
                if (helpElement.hasClass('hidden')) {
                    helpHoverElement.css('top', (helpLink.offset().top + 10) + 'px');
                    helpHoverElement.css('left', (helpLink.offset().left + 30) + 'px');
                    helpHoverElement.fadeIn(250);
                }
            });
            helpLink.mouseout(function() {
                helpHoverElement.fadeOut(250);
            });
            helpLink.insertBefore($(this));
        }
    });

    $('.open_all_help').click(function() {
        if( $('#'+this.rel+' .help.hidden').size() == 0 ) {
            $('#'+this.rel+' .help').slideUp().addClass('hidden').parent().next().removeClass('noborder');
        } else {
            $('#'+this.rel+' .help').slideDown().removeClass('hidden').parent().next().addClass('noborder');
        }
    });

    $('#logout_link').click(function(){
        cg.doAction({
            page: 'logout',
            successFn: function(json) {
                window.location.reload(true);
            }
        });
        return false;
    });

    // Turn all a buttons and submit buttons into pretty ones
    $("a.button, input:submit").button();
    
    if (cg.system && cg.system.update && cg.system.update.auto) {
        cg.system.update.auto.checkUpdates(true);
    }
});

cg.showHomepage = function() {
    // Show default homepage: System status
    var cp = $('#cp_basic');
    cp.show();
    cp.parent().show();
    $('#basic').addClass('active');
    cg.basic.clickHandler();
};

/*
 * Argument: one object with the following properties:
 *  - module: modulename (optional)
 *  - page: pagename (optional)
 *  - params: extra post parameters in object form, or querystring(does not work with file) (optional)
 *  - error_element: the element the error appears in (optional)
 *  - content_id: the id of the element the ajax loader should appear in (optional)
 *  - successFn: function that gets called with the json as parameter when the request was successful (optional)
 *  - errorFn:  function that gets called when the request fails (optional)
 *  - url: Can be overridden for testing purposes, default 'ajaxserver.php'
 */
cg.doAction = function(opts) {
    if (opts.error_element) {
        if ($.isArray(opts.error_element)) {
            $.each(opts.error_element, function(i, el) {
                el.slideUp(150);
            });
        } else {
            opts.error_element.slideUp(150);
        }
    }
    if (opts.content_id) {
        cg.showAjaxLoader(opts.content_id);
    }
    var postFields = {};
    if (opts.module) {
        postFields.module = opts.module;
    }
    if (opts.page) {
        postFields.page = opts.page;
    }
    if (opts.params) {
        for (var field in opts.params) {
            postFields[field] = opts.params[field];
        }
    }
    $.ajax({
        url: cg.debug && opts.url ? opts.url : 'ajaxserver.php',
        type: 'POST',
        data: postFields,
        error: function(request, textStatus, error) {
            if (opts.content_id) {
                cg.hideAjaxLoader(opts.content_id);
            }
            cg.handleRequestError(request, textStatus, opts.error_element, opts.errorFn);
        },
        success: function(data, textStatus, request) {
            if (opts.content_id) {
                cg.hideAjaxLoader(opts.content_id);
            }
            $('#'+opts.form_id+' input[type=submit]').removeAttr('disabled');
            cg.processReply(data, opts.error_element, opts.successFn, opts.errorFn);
        }
    });
};

/*
 * Argument: one object with the following properties:
 *  - form_id: id of the form
 *  - error_element: the element the error appears in (optional)
 *  - successFn: function that gets called with the json as parameter when the request was successful (optional)
 *  - errorFn:  function that gets called when the request fails (optional)
 *  - url: Can be overridden for testing purposes, default 'ajaxserver.php'
 */
cg.doFormAction = function(opts) {
    $('#'+opts.form_id+' input[type=submit]').attr('disabled', 'disabled');
    $('#'+opts.form_id+' input.formfield-error').removeClass('formfield-error');
    cg.showAjaxLoader(opts.form_id);
    if (opts.error_element) {
        if ($.isArray(opts.error_element)) {
            $.each(opts.error_element, function(i, el) {
                el.slideUp(150);
            });
        } else {
            opts.error_element.slideUp(150);
        }
    }
    $('#'+opts.form_id).ajaxSubmit({
        url: cg.debug && opts.url ? opts.url : 'ajaxserver.php',
        type: 'POST',
        dataType: 'xml',
        clearForm: false,
        resetForm: false,
        error: function(request, textStatus, error) {
            cg.hideAjaxLoader(opts.form_id);
            $('#'+opts.form_id+' input[type=submit]').removeAttr('disabled');
            cg.handleRequestError(request, textStatus, opts.error_element, opts.errorFn);
        },
        success: function(data, textStatus, request) {
            cg.hideAjaxLoader(opts.form_id);
            $('#'+opts.form_id+' input[type=submit]').removeAttr('disabled');
            cg.processReply(data, opts.error_element, opts.successFn, opts.errorFn);
        }
    });
}
cg.handleRequestError = function(request, textStatus, error_element, errorFn) {
    switch(textStatus) {
        case 'parsererror':
            if (request.responseText) {
                cg.displayError('Server response:<br><pre><code class="parse-error-output">'+$('<div/>').text(request.responseText).html()+'</code></pre>', 'Invalid response', error_element);
            } else {
                cg.displayError('The server returned an empty response', 'Invalid response', error_element);
            }
            break;
        case 'timeout':
            cg.displayError('The page request timed out.', 'Request time out', error_element);
        default:
            cg.displayError('The server was unreachable', 'Server unreachable', error_element);
            break;
    }
    if (errorFn) {
        errorFn();
    }
};
cg.displayError = function(message, title, error_element) {
    var str = '';
    if (error_element) {
        if ($.isArray(error_element)) {
            $.each(error_element, function(i, el) {
                cg.displayError(message, title, el);
            });
            return;
        }
        error_element.slideUp(350);
        if (title) {
            str += '<h3 class="error">'+title+'</h3>';
        }
        error_element.html(str+'<p class="error">'+message+'</p>');
        error_element.slideDown(450);
    } else {
        cg.alert(title, message);
    }
};
cg.processReply = function(data, error_element, successFn, errorFn) {
    var json = $.xml2json(data);

    if (json && json.action && json.action.toLowerCase() == 'ok') {
        if (json.message) {
            cg.alert('Server notice', json.message);
        }
        if (successFn) {
            successFn(json);
        }
        return true;
    } else if (json) {
        if (json.action && json.action.toLowerCase() == 'login-error') {
            cg.alert('Session timeout', json.message+'<br>You will be redirected to the login page.');
            window.setTimeout("window.location.reload(true);", 3000);
            if (errorFn) {
                errorFn();
            }
            return false;
        }
        if (json.message) {
            if ($.isArray(json.message)) {
                var msg = '<ul>'
                $.each(json.message, function(i, message){
                    msg += '<li>'+message.text[0]+'</li>';
                });
                msg += '</ul>';
                cg.displayError(msg, 'An exception occurred', error_element);
            } else {
                cg.displayError(json.message.text[0], 'An exception occurred', error_element);
            }
        }
        if (json.formfield) {
            if ($.isArray(json.formfield)) {
                $.each(json.formfield, function(i, formfield){
                    cg.markFieldInvalid(formfield.id);
                });
            } else {
                cg.markFieldInvalid(json.formfield.id);
            }
        }
        if (!json.message && !json.formfield) {
            cg.displayError('<p>An unknown error occured! Action failed.</p>', 'Unknown error', error_element);
        }
    }
    if (!json) {
        cg.displayError('<p>An unknown error occured!</p><p>Server response:</p><pre><code class="parse-error-output">'+$('<div/>').text(data).html()+'</code></pre>', 'Unknown error', error_element);
    }
    if (errorFn) {
        errorFn();
    }
    return false;
};
cg.markFieldInvalid = function(field_id) {
    $('#'+field_id).addClass('formfield-error');
};
cg.resetForm = function(form_id) {
    $('#'+form_id+'_error').hide();
    $('#'+form_id+' input').each(function(i, input){
        input = $(input);
        input.removeClass('formfield-error');
        switch (input.attr('type')) {
            case 'checkbox':
                input.trigger('click');
            case 'radio':
                input.removeAttr('checked');
                break;
            case 'submit':
                input.removeAttr('disabled');
                break;
            case 'hidden':
                // Do nothing
                break;
            default:
                input.val('');
                break;
        }
    });
    $('#'+form_id+' select').each(function(i, select){
        select = $(select);
        select.removeClass('formfield-error');
        select.val('');
        select.trigger('change');
    });
};
cg.alert = function(title, message) {
    $('<div><p>'+message+'</p></div>').dialog({
        title: title,
        autoOpen: true,
        resizable: false,
        width: 300,
        minHeight: 100,
        modal: true,
        buttons: {
            "OK": function() {
                $(this).dialog("close");
            }
        }
    });
};
cg.confirm = function(title, message, successFn, successTxt, failFn, failTxt) {
    var btns = {};
    if (failTxt) {
        btns[failTxt] = function() {
            if (failFn) {
                failFn();
            }
            $(this).dialog('close');
        };
    } else {
        btns['Cancel'] = function() {
            if (failFn) {
                failFn();
            }
            $(this).dialog('close');
        };
    }
    if (successTxt) {
        btns[successTxt] = function() {
            if (successFn) {
                successFn();
            }
            $(this).dialog('close');
        };
    } else {
        btns['OK'] = function() {
            if (successFn) {
                successFn();
            }
            $(this).dialog('close');
        };
    }
    $('<div><p>'+message+'</p></div>').dialog({
        title: title,
        autoOpen: true,
        resizable: false,
        width: 400,
        minHeight: 100,
        modal: true,
        buttons: btns
    });
};

cg.rebootNotice = function(seconds) {
    if (!seconds) {
        seconds = 75;
    }
    $('<div><p>The device is rebooting, please wait. The page will refresh in <span id="reboot_countdown_timer">'+seconds+'</span> seconds.</p></div>').dialog({
        title: 'Device rebooting',
        autoOpen: true,
        resizable: false,
        width: 300,
        minHeight: 100,
        modal: true,
        closeOnEscape: false,
        beforeClose: function() {
            return false;
        }
    });
    cg.data.reboot_seconds = seconds;
    window.setInterval('cg.rebootCountDown();', 1000);
};

cg.rebootCountDown = function() {
    cg.data.reboot_seconds--;
    
    $('#reboot_countdown_timer').html(cg.data.reboot_seconds);

    if (cg.data.reboot_seconds <= 0) {
        window.location.reload(true);
    }
}

cg.showAjaxLoader = function(el_id) {
    if ($.isArray(el_id)) {
        $.each(el_id, function(i, el){
            cg.showAjaxLoader(el);
        });
        return;
    }

    var element = $('#'+el_id);
    var loader = $('#'+el_id+'_loader');
    if (!loader.length) {
        loader = $('<div class="ajax-form-loader" id="'+el_id+'_loader"><img src="images/loader.gif" alt="loader"/> Loading..</div>');
        element.append(loader);
    }
    var position = element.position();
    if (position) {
        var top = position.top;
        var left = position.left;
        if (element.hasClass('dialog')) {
            top = element.height() / 2 - (32 / 2);
            left = element.width() / 2 - (120 / 2);
        } else if (top == 0 && left == 0) {
            top = 60;
            left = 352;
        } else {
            top = top + (element.height() / 2 - (32 / 2));
            left = left + (element.width() / 2 - (120 / 2));
        }
        loader.css('top', top);
        loader.css('left', left);
        loader.show();
    }
};

cg.hideAjaxLoader = function(el_id) {
    if ($.isArray(el_id)) {
        $.each(el_id, function(i, el){
            cg.hideAjaxLoader(el);
        });
        return;
    }

    $('#'+el_id+'_loader').hide();
};

String.prototype.trim = function() {
    return this.replace(/(^\s+|\s+$)/,'');
}

if(!Array.indexOf){
    Array.prototype.indexOf = function(obj){
        for(var i = 0; i < this.length; i++){
            if (this[i] == obj){
                return i;
            }
        }
        return -1;
    }
}