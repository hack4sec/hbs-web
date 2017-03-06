function number_format (number, decimals, dec_point, thousands_sep) {
    //  discuss at: http://phpjs.org/functions/number_format/
    // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: davook
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Theriault
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Michael White (http://getsprink.com)
    // bugfixed by: Benjamin Lupton
    // bugfixed by: Allan Jensen (http://www.winternet.no)
    // bugfixed by: Howard Yeend
    // bugfixed by: Diogo Resende
    // bugfixed by: Rival
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    //  revised by: Luke Smith (http://lucassmith.name)
    //    input by: Kheang Hok Chin (http://www.distantia.ca/)
    //    input by: Jay Klehr
    //    input by: Amir Habibi (http://www.residence-mixte.com/)
    //    input by: Amirouche
    //   example 1: number_format(1234.56);
    //   returns 1: '1,235'
    //   example 2: number_format(1234.56, 2, ',', ' ');
    //   returns 2: '1 234,56'
    //   example 3: number_format(1234.5678, 2, '.', '');
    //   returns 3: '1234.57'
    //   example 4: number_format(67, 2, ',', '.');
    //   returns 4: '67,00'
    //   example 5: number_format(1000);
    //   returns 5: '1,000'
    //   example 6: number_format(67.311, 2);
    //   returns 6: '67.31'
    //   example 7: number_format(1000.55, 1);
    //   returns 7: '1,000.6'
    //   example 8: number_format(67000, 5, ',', '.');
    //   returns 8: '67.000,00000'
    //   example 9: number_format(0.9, 0);
    //   returns 9: '1'
    //  example 10: number_format('1.20', 2);
    //  returns 10: '1.20'
    //  example 11: number_format('1.20', 4);
    //  returns 11: '1.2000'
    //  example 12: number_format('1.2000', 3);
    //  returns 12: '1.200'
    //  example 13: number_format('1 000,50', 2, '.', ' ');
    //  returns 13: '100 050.00'
    //  example 14: number_format(1e-8, 8, '.', '');
    //  returns 14: '0.00000001'

    number = (number + '')
        .replace(/[^0-9+\-Ee.]/g, '')
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec)
            return '' + (Math.round(n * k) / k)
                    .toFixed(prec)
        }
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.')
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1)
            .join('0')
    }
    return s.join(dec)
}


function refreshWorkTasksTable() {
    $.get("/work-tasks/index/?ajax=1", function (data) {
        $("#workTasksMainContent").html(data)
    })
    $.cookie('getCurrentWorkTaskId', getCurrentWorkTaskId())
    applyFiltersWorkTasksList()
}

function fillDictNameFromPath(path) {
    path = path.replace(/\\/g, '/')
    if (path.indexOf('/') != -1) {
        path = strrchr(path, "/").substring(1)
    }
    $('#dictForm_name').val(path)
}

function fillHashlistNameFromPath(path)  {
    path = path.replace(/\\/g, '/')
    if (path.indexOf('/') != -1) {
        path = strrchr(path, "/").substring(1)
    }
    $('#hashlistsForm_name').val(path)
}

function fillRulesNameFromPath(path) {
    path = path.replace(/\\/g, '/')
    if (path.indexOf('/') != -1) {
        path = strrchr(path, "/").substring(1)
    }
    $('#rulesForm_name').val(path)
}

function strrchr(haystack, needle) {
    //  discuss at: http://phpjs.org/functions/strrchr/
    // original by: Brett Zamir (http://brett-zamir.me)
    //    input by: Jason Wong (http://carrot.org/)
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //   example 1: strrchr("Line 1\nLine 2\nLine 3", 10).substr(1)
    //   returns 1: 'Line 3'

    var pos = 0;

    if (typeof needle !== 'string') {
        needle = String.fromCharCode(parseInt(needle, 10));
    }
    needle = needle.charAt(0);
    pos = haystack.lastIndexOf(needle);
    if (pos === -1) {
        return false;
    }

    return haystack.substr(pos);
}

function changeTaskPriority(taskId, priority) {
    priority = prompt(L_NEW_PRIORITY_VALUE, priority)
    if (priority != null) {
        $.get("/work-tasks/change-task-priority/id/" + taskId + '/priority/' + priority, function (data) {
            window.location.reload()
        })
    }
}

function activeIncrement() {
    if ($('#taskForm_increment').prop('checked')) {
        $('#increment_min_tr').show()
        $('#increment_max_tr').show()
    } else {
        $('#increment_min_tr').hide()
        $('#increment_max_tr').hide()
    }
}

function activeSalts() {
    if ($('#hashlistsForm_have_salts').prop('checked')) {
        $('#delimiter_tr').show()
    } else {
        $('#delimiter_tr').hide()
    }
}

function startAllWorkTasks() {
    if (confirm(L_ALL_WORK_TASKS_START_CONFIRM)) {
        $.get('/work-tasks/start-all/')
    }
}

function stopAllWorkTasks() {
    if (confirm(L_ALL_WORK_TASKS_STOP_CONFIRM)) {
        $.get('/work-tasks/stop-all/')
    }
}

function createDialogBox(title, url, width, height) {
    if($('#dialogbox')) {
        $('#dialogbox').remove()
    }
    $('<div id="dialogbox">Loading...</div>').dialog({
        height: height,
        width: width,
        modal: true,
        title: title
    }).load(url)
}

function getCurrentWorkTaskId() {
    var taskId = ""
    $.ajax({
        url: "/work-tasks/get-current-work-task-id",
        type: 'get',
        dataType: 'text',
        async: false,
        success: function(data) {
            taskId = data
        }
    });
    return taskId
}

function checkCurrentWorkTask() {
    if (getCurrentWorkTaskId() != $.cookie('getCurrentWorkTaskId')) {
        window.location.reload()
    }
}

function refreshCurrentWorkTaskData() {
    if ($.cookie('getCurrentWorkTaskId') == '0') {
        return;
    }

    $.get(
        '/work-tasks/get-json-work-task-data-for-list/id/' + $.cookie('getCurrentWorkTaskId'),
        function (data) {
            jQuery('#wt' + $.cookie('getCurrentWorkTaskId') + 'status').html(data.status)
            jQuery('#wt' + $.cookie('getCurrentWorkTaskId') + 'process').html(data.process)
            jQuery('#wt' + $.cookie('getCurrentWorkTaskId') + 'progress').html(data.progress)
            jQuery('#wt' + $.cookie('getCurrentWorkTaskId') + 'temp').html(data.temp + '&deg;C')

            if (data.timeAll == 'n/a') {
                jQuery('#wt' + $.cookie('getCurrentWorkTaskId') + 'time').html(data.timeAll)
            } else {
                jQuery('#wt' + $.cookie('getCurrentWorkTaskId') + 'time').html(
                    '<span title="' + data.timeAll + '">' + data.timeNeed + '</span>'
                )
            }

            if (Array.isArray(data.hc_rechash)) {
                jQuery('#wt' + $.cookie('getCurrentWorkTaskId') + 'hashes').html(
                    '<span title="' + number_format(data.hc_rechash[1], 0, ",", " ") + "/" +
                        number_format(data.hc_rechash[1]-data.hc_rechash[0], 0, ",", " ") + "/" +
                        number_format(data.hc_rechash[0], 0, ",", " ") + '">' +
                        '<nobr>' + number_format(data.hc_rechash[0], 0, ",", " ") + '</nobr>' +
                    '</span>'
                )
            } else {
                jQuery('#wt' + $.cookie('getCurrentWorkTaskId') + 'hashes').html(data.hc_rechash)
            }
        },
        'json'
    )
}

function resetFilters() {
    jQuery('input[name^="filter_"]:checked').each(
        function (item){
            jQuery(this).prop('checked', false)
        }
    )
    jQuery("#filter_hashlist").val("0")
    applyFiltersWorkTasksList()
}

function applyFiltersWorkTasksList() {
    var filters_arr = []
    var show = []
    jQuery('input[name^="filter_"]:checked').each(
        function (item){
            filters_arr[filters_arr.length] = this.name
            show[show.length] = this.name.replace('filter_', '')
        }
    )

    if (!show.length) {
        jQuery('#workTasksTable tr[id^="wt"]').each(
            function () {
                jQuery(this).show()
            }
        )
    } else {
        jQuery('#workTasksTable tr[id^="wt"]').each(
            function (item) {
                var hide = true
                for (i in show) {
                    if (jQuery(this).hasClass('task'+show[i])) {
                        hide = false
                        break
                    }
                }
                hide ? jQuery(this).hide() : jQuery(this).show()
            }
        )
    }

    if (jQuery("#filter_hashlist").val() != "0") {
        jQuery('#workTasksTable tr[id^="wt"]').each(
            function (item) {
                if (!jQuery(this).hasClass('hashlist' + jQuery("#filter_hashlist").val())) {
                    jQuery(this).hide()
                }
            }
        )
    } /*else {
        jQuery('#workTasksTable tr[id^="wt"]').each(
            function (item) {
                jQuery(this).show()
            }
        )
    }*/
    $.cookie('filter_status', JSON.stringify(filters_arr), {expires: 100})
    $.cookie('filter_hashlist', jQuery("#filter_hashlist").val(), {expires: 100})
}

function refreshHashlistsData() {
    $.getJSON( "/hashlists/get-hashlists-json-data/", function( data ) {
        for (id in data) {
            var ncPercents = data[id]['cracked'] / (data[id]['not_cracked'] + data[id]['cracked']) * 100;
            $("#hashlist" + id + "cracked").html(data[id]['cracked'] + " (" + data[id]['cracked_percents'] + "%)")
            $("#hashlist" + id + "not_cracked").html(data[id]['not_cracked'] + " (" + data[id]['not_cracked_percents'] + "%)")
            $("#hashlist" + id + "status").html(data[id]['status_title'])

            if (data[id]['status'] == 'ready' && $("#trHashlist" + id).hasClass('hashlist-notready')) {
                $("#trHashlist" + id).removeClass('hashlist-notready')
            }
            if (data[id]['status'] != 'ready' && !$("#trHashlist" + id).hasClass('hashlist-notready')) {
                $("#trHashlist" + id).addClass('hashlist-notready')
            }
        }
    });
}

function massActionsToggle() {
    if(jQuery('input[name="mass[]"]:checked').length) {
        jQuery('#massActionsBlock').show()
    } else {
        jQuery('#massActionsBlock').hide()
    }
}

function massAction(action) {
    jQuery('#mass-action-name').val(action)
    jQuery('#massActionsForm').submit()
}