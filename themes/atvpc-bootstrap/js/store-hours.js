var hours = [
    {   "day"      : "Sunday",
        "open"     : 0,
        "close"    : 0,
        "shipping" : 0
    },
    {   "day"      : "Monday",
        "open"     : 800,
        "close"    : 1800,
        "shipping" : 1630
    },
    {   "day"      : "Tuesday",
        "open"     : 800,
        "close"    : 1800,
        "shipping" : 1630
    },
    {   "day"      : "Wednesday",
        "open"     : 800,
        "close"    : 1800,
        "shipping" : 1630
    },
    {   "day"      : "Thursday",
        "open"     : 800,
        "close"    : 1800,
        "shipping" : 1630
    },
    {   "day"      : "Friday",
        "open"     : 800,
        "close"    : 1800,
        "shipping" : 1630
    },
    {   "day"      : "Saturday",
        "open"     : 900,
        "close"    : 1500,
        "shipping" : 0
    }
];

var holidays = {
    "0000-07-04" : "The 4th of July",
    "2017-11-23" : "Thanksgiving",
    "2018-11-22" : "Thanksgiving",
    "2019-11-28" : "Thanksgiving",
    "2020-11-26" : "Thanksgiving",
    "0000-12-25" : "Christmas"
};


/* ---------- DO NOT EDIT BELOW ---------- */

function dayName(day) {
    var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    return days[day];
}

function prettyTime(time) {
    time        = String(time);
    var hours   = time.slice(0, -2);
    var minutes = time.slice(-2);
    var ampm    = null;

    if (hours < 12) {
        ampm = "am";

        if (hours === 0) {
            hours = 12;
        }
    }
    else {
        ampm = "pm";

        if (hours > 12) {
            hours = hours - 12;
        }
    }

    return hours + ":" + minutes + ampm;
}

function storeHours() {
    var now = new Date().getTime();
    var nowEST = moment(now).tz("America/New_York");

    var day = moment(nowEST).day();
    var time = moment(nowEST).format("HHmm");
    var holidayExactDate = moment(nowEST).format("YYYY-MM-DD");
    var holidayEveryYear = "0000-" + moment(nowEST).format("MM-DD");

    /* OPEN / CLOSED STATUS */
    var status = "";
    var style = "";
    var hover = "";

    if (typeof holidays[holidayExactDate] != "undefined") { 
        /* floating day holidays, like easter and thanksgiving */
        status = "Closed";
        style  = "store-hours-closed";
        hover  = "Sorry, we're closed for " + holidays[holidayExactDate];
    }
    else if (typeof holidays[holidayEveryYear] != "undefined") { 
        /* holidays on the same day, like christmas */
        status = "Closed";
        style  = "store-hours-closed";
        hover  = "Sorry, we're closed for " + holidays[holidayEveryYear];
    }
    else {
        /* regular days, non-holiday */
        if (hours[day].open === hours[day].close) {
            status = "Closed";
            style  = "store-hours-closed";
            hover = "Sorry, we're closed on " + dayName(day) + "s";
        }
        else if (time < hours[day].open) {
            status = "Closed";
            style  = "store-hours-closed";
            hover = "We will open today at " + prettyTime( hours[day].open );
        }
        else if (time >= hours[day].close) {
            status = "Closed";
            style  = "store-hours-closed";
            hover  = "Sorry, we're closed for the day";
        }
        else if ( (time - hours[day].open) <= 30 ) {
            status = "Opening";
            style  = "store-hours-warn";
            hover = "If you call is not answered, please try back in a few minutes";
        }
        else if (hours[day].close - time - 40 <= 15) {
            status = "Closing";
            style  = "store-hours-warn";
            hover = "Technical assistance and returns may be asked to call back on the next business day";
        }
        else {
            status = "Open";
            style  = "store-hours-open";
            hover = "Have a question? Call us, we're open!";
        }
    }

    /* SHIPPING STATUS */
    var shipping = "";

    if ( status === "Closed" ) {
        shipping = "Online orders ship next business day";
    }
    else {
        if (hours[day].shipping === 0 || time >= hours[day].shipping) {
            shipping = "Orders ship next business day";
        }
        else {
            shipping = "Orders placed now, ship today!";
        }
    }

    /* HTML OUTPUT */
    $("#store-hours").prop("title", hover);
    $("#store-hours-status").addClass(style);
    $("#store-hours-status").html(status);
    $("#store-hours-shipping").html(shipping);
}


$( document ).ready(function() {
    $.getScript("themes/atvpc-bootstrap/js/moment.min.js", function() {
        $.getScript("themes/atvpc-bootstrap/js/moment-timezone-with-data.min.js", function() {
            storeHours();
        });
    });
});