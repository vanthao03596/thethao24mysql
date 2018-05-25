/**
 * Created by MrDoan on 04/07/2016.
 */
var chart;
var sArrow;
var mArrow;
var hArrow;

AmCharts.ready(function () {

    // clock is just an angular gauge with three arrows
    chart = new AmCharts.AmAngularGauge();
    chart.startDuration = 0.3;

    // for simplicyty, we use only one axis
    var axis = new AmCharts.GaugeAxis();
    axis.startValue = 0;
    axis.endValue = 12;
    axis.valueInterval = 1;
    axis.minorTickInterval = 0.2;
    axis.showFirstLabel = false;
    axis.startAngle = 0;
    axis.endAngle = 360;
    axis.axisAlpha = 0.3;
    chart.addAxis(axis);

    // hour arrow
    hArrow = new AmCharts.GaugeArrow();
    hArrow.radius = "50%";
    hArrow.clockWiseOnly = true;

    // minutes arrow
    mArrow = new AmCharts.GaugeArrow();
    mArrow.radius = "80%";
    mArrow.startWidth = 6;
    mArrow.nailRadius = 0;
    mArrow.clockWiseOnly = true;

    // seconds arrow
    sArrow = new AmCharts.GaugeArrow();
    sArrow.radius = "90%";
    sArrow.startWidth = 3;
    sArrow.nailRadius = 4;
    sArrow.color = "#CC0000";
    sArrow.clockWiseOnly = true;

    // update clock before adding arrows to avoid initial animation
    updateClock();

    // add arrows
    chart.addArrow(hArrow);
    chart.addArrow(mArrow);
    chart.addArrow(sArrow);

    chart.write("div-clock");

    // update each second
    setInterval(updateClock, 1000);
});

// update clock
function updateClock() {
    // get current date
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();

    // set hours
    hArrow.setValue(hours + minutes / 60);
    // set minutes
    mArrow.setValue(12 * (minutes + seconds / 60) / 60);
    // set seconds
    sArrow.setValue(12 * date.getSeconds() / 60);
}
