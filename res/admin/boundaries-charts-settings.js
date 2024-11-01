if (areacharts_vars_admin.whaac_boundaries_appearance === '') {
    var whaac_boundaries_appearance = '0.4';
} else {
    var whaac_boundaries_appearance = areacharts_vars_admin.whaac_boundaries_appearance;
}
if (areacharts_vars_admin.whaac_boundaries_fill === '') {
    var whaac_boundaries_fill = 'origin';
} else {
    var whaac_boundaries_fill = areacharts_vars_admin.whaac_boundaries_fill;
}
if (areacharts_vars_admin.whaac_boundaries_color === '') {
    var whaac_boundaries_color = '005BFF';
} else {
    var whaac_boundaries_color = areacharts_vars_admin.whaac_boundaries_color;
}
if (areacharts_vars_admin.whaac_boundaries_data === '') {
    var whaac_boundaries_data = areacharts_vars_admin.whaac_default_data;
} else {
    var whaac_boundaries_data = areacharts_vars_admin.whaac_boundaries_data.replace(/([\]["])/g, '').split(",");
}
if (areacharts_vars_admin.whaac_boundaries_x_labels === '') {
    var whaac_boundaries_x_labels = areacharts_vars_admin.whaac_default_x_labels;
} else {
    var whaac_boundaries_x_labels = areacharts_vars_admin.whaac_boundaries_x_labels.replace(/([\]["])/g, '').split(",");
}
if (areacharts_vars_admin.whaac_implode_data === '') {
    var whaac_implode_data = areacharts_vars_admin.whaac_default_implode_data
} else {
    var whaac_implode_data = areacharts_vars_admin.whaac_implode_data;
}
if (areacharts_vars_admin.whaac_boundaries_dataname === '') {
    var whaac_boundaries_dataname = 'Area Name';
} else {
    var whaac_boundaries_dataname = areacharts_vars_admin.whaac_boundaries_dataname;
}
if (areacharts_vars_admin.whaac_grid_lines === '') {
    var gridLines = 'true';
} else {
    var gridLines = areacharts_vars_admin.whaac_grid_lines;
}


var utils = Samples.utils;

var options = {
    maintainAspectRatio: false,
    spanGaps: false,
    elements: {
        line: {
            tension: 0.000001
        }
    },
    plugins: {
        filler: {
            propagate: false
        }
    },
    scales: {
        xAxes: [{
            ticks: {
                autoSkip: false,
                maxRotation: 0
            }
        }]
    }
};

if (gridLines === 'true') {
    var gridLinesValue = gridLines;
} else {
    var gridLinesValue = false;
}
jQuery('input.whaac_grid_lines').click(function () {
    if (jQuery(this).prop('checked')) {
        gridLinesValue = true;
    } else {
        gridLinesValue = false;
    }
    init();
});

var fill_val = whaac_boundaries_fill;
jQuery('input.whaac_boundaries_fill').change(function () {
    fill_val = jQuery(this).val();
    init();
});

var appearance_val = whaac_boundaries_appearance;
jQuery('input.whaac_boundaries_appearance').change(function () {
    appearance_val = jQuery(this).val();
    init();
});

var color = whaac_boundaries_color;
jQuery('input.whaac_boundaries_color.jscolor').val('#' + color);
jQuery('input.whaac_boundaries_color.jscolor').change(function () {
    color = jQuery(this).val();
    init();
});

function init() {
    var yLabels = {};
    jQuery.each(whaac_implode_data, function (key, val) {
        if ([val.value] != '') {
            yLabels[val.key] = val.value
        } else {
            yLabels[val.key] = val.key
        }
    });

    new Chart('boundaries', {
        type: 'line',
        data: {
            labels: whaac_boundaries_x_labels,
            datasets: [{
                backgroundColor: utils.transparentize('#' + color),
                borderColor: '#' + color,
                data: whaac_boundaries_data,
                label: whaac_boundaries_dataname,
                fill: fill_val,
                lineTension: appearance_val
            }]
        },
        options: Chart.helpers.merge(options, {
            title: {
                text: 'fill: ' + fill_val,
                display: true
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        drawBorder: true,
                        drawOnChartArea: gridLinesValue
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Y Values / Labels'
                    },
                    ticks: {
                        stepSize: 1,
                        callback: function (value, index, values) {
                            return yLabels[value];
                        }
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: true,
                        drawBorder: true,
                        drawOnChartArea: gridLinesValue
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'X Labels'
                    }
                }]
            }
        })
    });


}

init();


Chart.helpers.each(Chart.instances, function (chart) {
    var labels = chart.data.labels; // get labels

    jQuery.each(whaac_implode_data, function (key, val) {
        jQuery('#boundaries_data').append('<div class="boundaries_data">' +
            '<input type="text" class="whaac_boundaries_y_labels" name="whaac_boundaries_y_labels[]" required value="' + val.value + '" placeholder="Label">' +
            '<input type="number" min="-1000" max="1000"  name="whaac_boundaries_data[]" required value="' + val.key + '">' +
            '<button class="remove"><i class="fa fa-times"></i></button>' +
            '</div>');
    });

    jQuery(labels).each(function () {
        if (this.toString() !== 'null' && this.toString() !== '') {
            jQuery('#x_boundaries_labels').append('<div class="x_boundaries_labels"><input type="text" name="whaac_boundaries_x_labels[]" required value="' + (labels.toString() != 'null' ? this : '') + '" ><button class="remove"><i class="fa fa-times"></i></button></div>');
        }
    })

});

jQuery('#add_boundaries_data').on('click', function () {
    jQuery('#boundaries_data').append('<div class="boundaries_data">' +
        '<input type="text" class="whaac_boundaries_y_labels" required name="whaac_boundaries_y_labels[]" placeholder="Label">' +
        '<input type="number" min="-1000" max="1000" required name="whaac_boundaries_data[]">' +
        '<button class="remove"><i class="fa fa-times"></i></button>' +
        '</div>');

    jQuery('#add_boundaries_y_labels').show();

    if (jQuery('#add_boundaries_y_labels').hasClass('active')) {
        jQuery('.whaac_boundaries_y_labels').show();
    }
    return false; //prevent form submission
});


jQuery('#boundaries_data').on('click', '.remove', function () {
    jQuery(this).parent().remove();
    if (jQuery("#boundaries_data").find(".boundaries_data").length <= 0) {
        jQuery('#add_boundaries_y_labels').hide();
    }
    return false; //prevent form submission
});

if (jQuery("#boundaries_data").find(".boundaries_data").length <= 0) {
    jQuery('#add_boundaries_y_labels').hide();
}

jQuery('#add_boundaries_x_labels').on('click', function () {
    jQuery('#x_boundaries_labels').append('<div class="x_boundaries_labels"><input type="text" name="whaac_boundaries_x_labels[]" required class="whaac_boundaries_x_labels"><button class="remove"><i class="fa fa-times"></i></button></div>');

    return false; //prevent form submission
});

jQuery('#x_boundaries_labels').on('click', '.remove', function () {
    jQuery(this).parent().remove();
    return false; //prevent form submission
});


jQuery('#add_boundaries_y_labels').on('click', function () {
    jQuery(this).toggleClass('active');

    if (jQuery(this).hasClass('active')) {
        jQuery(this).html('Remove Labels <i class="fa fa-times"></i>');
        jQuery('.whaac_boundaries_y_labels').show().attr("required", true);
        jQuery('.whaac_boundaries_labels_check').prop('checked', true);
        jQuery('.whaac_y_val').show();
    } else {
        jQuery(this).html('Add Labels <i class="fa fa-plus"></i>');
        jQuery('.whaac_boundaries_labels_check').prop('checked', false);
        jQuery('input.whaac_boundaries_y_labels').attr("required", false).val('').hide();
        jQuery('.whaac_y_val').hide();
    }
    return false;
});

jQuery('.whaac_boundaries_labels_check').on('change', function () {
    if (jQuery(this).prop('checked')) {
        jQuery('.whaac_boundaries_y_labels').show();
        jQuery('#add_boundaries_y_labels').trigger('click')
        jQuery('.whaac_y_val').show();
    } else {
        jQuery('.whaac_boundaries_y_labels').hide();
        jQuery('#add_boundaries_y_labels').trigger('click');
        jQuery('.whaac_y_val').hide();
    }
});

if (areacharts_vars_admin.whaac_implode_data === '') {
    jQuery('.whaac_boundaries_labels_check').prop('checked', true);
}

if (jQuery('.whaac_boundaries_labels_check').prop('checked')) {
    jQuery('.whaac_boundaries_y_labels').show();
    jQuery('.whaac_y_val').show();
    jQuery('#add_boundaries_y_labels').trigger('click');
} else {
    jQuery('.whaac_y_val').hide();
    // jQuery('.whaac_boundaries_y_labels').hide().val('');
}

