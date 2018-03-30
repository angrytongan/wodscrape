Zepto(function($) {
    $('#add-workout').on('click', function() {
        var source = $('#source').val().replace(/ /g, '-');

        if (source) {
            $('#add-workout').prop('disabled', true);
            loadWorkout(source);
        }
    });

    $('#clear-workouts').on('click', function() {
        $('.workout').remove();
        clearSources();
    });

    $('body').on('click', '.remove-me', function() {
        var e = $(this).closest('.workout');
        e.removeClass('workout');
        forgetSource(e.prop('class'));
        e.remove();
    });

    $('body').on('click', '.popular-workout', function() {
        var source = $(this).text().replace(' ', '-');
        loadWorkout(source);
    });

    $('body').on('click', '.toggle-site-info', function() {
        $('div.site-info').toggleClass('hidden');
    });

    var loadWorkout = function(source) {
        $.ajax({
            type: 'GET',
            url: '/' + source + '.html',
            dataType: 'html',
            timeout: 5000,
            context: $('#workouts'),
            cache: false,
            success: function(d) {
                this.prepend('<div class="workout ' + source + '" id="' + source + '">' +
                    '<button class="remove-me">Remove</button>' +
                    d +
                    '</div>');

                /* google analytics */

                rememberSource(source);
            },
            error: function(xhr, type) {
                console.log(xhr.status + ': ' + error);
            },
            complete: function(xhr, status) {
                $('#add-workout').prop('disabled', false);
            }
        });
    };

    var loadWorkouts = function() {
        var sources = getSources();

        clearSources();    /* these will be added in during load */

        if (sources == "") {
            sources = "SkiWod,PushJerk,CrossFit-Linchpin,CrossFit-Invictus,CrossFit-Weightlifting,CrossFit-Mayhem,crossfit.com,Concept2-SkiErg,Concept2-Rower,Comptrain-Individual,Comptrain-Class";
        }

        if (sources) {
            var sources = sources.split(',');
            for (var i = 0; i < sources.length; i++) {
                if (sources[i]) {
                    loadWorkout(sources[i]);
                }
            }
        }
    };

    var addToJumps = function(source) {
        let s = source.replace(/\./g, '-');
        let l = source.replace(/-/g, ' ');

        $("#jumps ul").prepend('<li class="' + s + '"><a href="#' + source + '">' + l + '</a></li>');
    };
    var clearJumps = function() {
        $("#jumps ul").empty();
    };
    var delJump = function(source) {
        let s = source.replace(/\./g, '-');

        $("#jumps ul li." + s).remove();
    };

    var rememberSource = function(source) {
        addToCookie("wods", source);
        addToJumps(source);
    };
    var clearSources = function() {
        delCookie("wods");
        clearJumps(source);
    };
    var forgetSource = function(source) {
        var c = getCookie("wods");
        delCookie("wods");
        c = c
            .replace(source, '')
            .replace(/^,/,'')
            .replace(/,$/,'');

        if (c == '') {
            delCookie("wods");
        } else {
            addToCookie("wods", c);
        }
        delJump(source);
    };
    var getSources = function() {
        return getCookie("wods");
    };

    var addToCookie = function(cname, cvalue) {
        var c = getCookie(cname);
        if (c != '') {
            delCookie(cname);
            document.cookie = cname + "=" + c + "," + cvalue;
        } else {
            document.cookie = cname + "=" + cvalue;
        }
    };
    var getCookie = function(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };
    var delCookie = function(cname) {
        document.cookie = cname + "=; Expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    };

    loadWorkouts();
});
