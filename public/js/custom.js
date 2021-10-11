$(document)
    .ready(function () {
        $('.ui.dropdown')
            .dropdown()
        ;
        $('.ui.menu .dropdown')
            .dropdown({
                on: 'hover'
            })
        ;

        $('.avatar .progress').progress();

        $('.ui.checkbox')
            .checkbox()
        ;


        $('.shape')
            .eq(0)
            .shape('flip down')
            .delay(2000)
            .shape('flip down')
            .end()
        ;

        $('.ui.sticky')
            .sticky({
                offset: 60,
                context: '#igorhome'
            })
        ;

        $('#div_fos_user_registration_form_business_unit')
            .dropdown({
                onChange: function (value) {
                    $('.test.modal').modal('show');
                }
            })
        ;


        /** Something wrong, prepare for review
        var messageBoxHeight = $("#right_message").height();
        var countN = 0;

        function calculateHeight() {
            setTimeout(function(){ messageBoxHeight = $("#right_message").height(); }, 1000);
        }

        function removeTopMessage() {
            console.log(countN);
            $("#right_message a").eq(countN).remove();
            $("#right_message p").eq(countN).remove();
        }

        if(countN < 3) {
            removeTopMessage();
            countN = countN + 1;
        } **/

        /**
         *  it's terrible, make the fans of my macbook pro crazy >_<
         */
        //$(document).snowfall({deviceorientation : true, round : true, minSize: 1, maxSize:8,  flakeCount : 250});
    })
;

/**
 * Enter Key shortcut
 */
var KEY_ENTER_COMMAND_CLOSED = 1;
var KEY_ENTER_COMMAND_OPENED = 2;
var KEY_ENTER_SEARCH = 3;
var KEY_ENTER_IGOR_COMMAND = 4;
var KEY_ENTER_COMMAND_INPUT = 5;

var flag = KEY_ENTER_COMMAND_CLOSED;

/**
 * Get current Enter key state as upside definition
 */
function getEnterState() {
    switch (true) {
        case $("#igor-command-input input").val() && $("#igor-command-input input").is(':focus'):
            flag = KEY_ENTER_IGOR_COMMAND;
            break;
        case $("#search").val() && $("#search").is(':focus'):
            flag = KEY_ENTER_SEARCH;
            break;
        case $("#command-input-text").val() && $("#command-input-text").is(':focus'):
            flag = KEY_ENTER_COMMAND_INPUT;
            break;
        case "" == $("#igor-command-input input").val() == $("#search").val() == $("#command-input-text").val():
            flag = (flag == KEY_ENTER_COMMAND_OPENED) ? KEY_ENTER_COMMAND_OPENED : KEY_ENTER_COMMAND_CLOSED;
    }
}

function ajaxPostCommand() {
    var commandContent = $("#command-input-text").val();
    var csrfToken = $("[name='_csrf_token']").val();
    commandDimmerClose();
    $.ajax({
        type: "POST",
        url: "command/post",
        dataType: "json",
        data: { command:commandContent, csrf:csrfToken },
        success: function(data) {
            switch (data.status) {
                case 'success':
                    console.log("command: " + data.command);
                    console.log("new token: " + data.token);
                    $("[name='_csrf_token']").val(data.token);
                    break;
                case 'error':
                    console.log('get error');
                    console.log(data);
            }
        }
    })
}

function commandDimmerClose() {
    $('body > .command.dimmer')
        .transition('flash', function () {
            $('#command-input-text').val("");
            $('body > .command.dimmer').dimmer('hide');
        })
    ;
}

$(document).keypress(function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    switch (code) {
        case 9 || (115 && e.ctrlKey):
            $("#igor-command").css("visibility", "visible");
            $("#igor-command").transition('jiggle');
            $("#igor-command input").focus();
            break;
        case 13:
            getEnterState();
            switch (flag) {
                case KEY_ENTER_COMMAND_CLOSED:
                    $('body > .command.dimmer')
                        .dimmer('show', function () {
                            $('body > .command.dimmer').transition('jiggle');
                        })
                    ;
                    $('#command-input-text').focus();
                    flag = KEY_ENTER_COMMAND_OPENED;
                    break;
                case KEY_ENTER_COMMAND_OPENED:
                    flag = KEY_ENTER_COMMAND_CLOSED;
                    commandDimmerClose();
                    break;
                case KEY_ENTER_COMMAND_INPUT:
                    flag = KEY_ENTER_COMMAND_CLOSED;
                    ajaxPostCommand();
                    break;
            }
            break;
    }

});
