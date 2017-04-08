<head>
    <title>Big Data Group #3</title>
    
    <script src="jquery/jquery-3.1.1.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/css/bootstrap-slider.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/bootstrap-slider.min.js"></script>

    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.js"></script>

    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/9e19aba51c.js"></script>

    <meta name="description" content="Twitter Sentiment Analysis!">
    <meta charset="UTF-8">

    <style type="text/css">
        nav {
            box-shadow: 5px 4px 5px #000;
        }
        body {
            font-family: 'PT Sans', sans-serif;
            font-size: 13px;
            font-weight: 400;
            position: relative;
            background: rgb(26, 49, 95);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(26, 49, 95, 1)), color-stop(10%, rgba(26, 49, 95, 1)), color-stop(24%, rgba(29, 108, 141, 1)), color-stop(37%, rgba(41, 136, 151, 1)), color-stop(77%, rgba(39, 45, 100, 1)), color-stop(90%, rgba(26, 49, 95, 1)), color-stop(100%, rgba(26, 49, 95, 1)));
            filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#1a315f', endColorstr='#1a315f', GradientType=0);
        }
        input { 
            text-align: center; 
        }
        .col-centered {
            float: none;
            margin: 0 auto;
        }
        .panel-default {
            margin: 30 auto;
            height: 530px;
        }
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        #ex1Slider .slider-selection {
            background: #BABABA;
        }
    </style>
</head>

<body>
    <div>
        <div class="col-centered col-sm-11">

            <!--Space between canvas and top of document. Required to seperate nav bar from canvas-->
            <br>
            <br>
            <br>
            <br>

            <!--Nav bar and branding-->
            <nav class="navbar navbar-inverse navbar-fixed-top" style="border-radius:0">
                <div class="container-fluid">
                </div>
            </nav>
     
            <!--Just branding-->
            <div class="panel col-lg-6 col-centered">
                <div class="panel-body">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">#</span>
                        <input type="text" id="form" class="form-control" placeholder="Search for a hashtag!" aria-describedby="basic-addon1">
                    </div>
                    <br>
                    <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="1" data-slider-max="100" data-slider-step="1" data-slider-value="15"/>
                    <br>
                    <br>
                    <form id="searchType">
                        <label class="radio-inline"><input type="radio" name="searchBy" value="popular" checked>Popular</label>
                        <label class="radio-inline"><input type="radio" name="searchBy" value="recent">Most Recent</label>
                    </form>
                    <br>
                    <button type="button" id="submit" class="btn btn-primary">&nbsp&nbsp&nbspSearch&nbsp&nbsp&nbsp</button>                    
                </div>
            </div>

            <!-- Stores the emotional tone canvas -->
            <div class="row">
                <div class="col-lg-12 col-centered" id="canvasArea">
                    <div class="panel panel-default">
                        <div class="panel-body" id="graphArea1">
                        <!--the graphs will be generated by javascript here-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stores the emotional tone canvas -->
            <div class="row">
                <div class="col-lg-12 col-centered" id="canvasArea">
                    <div class="panel panel-default">
                        <div class="panel-body" id="graphArea2">
                        <!--the graphs will be generated by javascript here-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stores the emotional tone canvas -->
            <div class="row">
                <div class="col-lg-12 col-centered" id="canvasArea">
                    <div class="panel panel-default">
                        <div class="panel-body" id="graphArea3">
                        <!--the graphs will be generated by javascript here-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stores the emotional tone canvas -->
            <div class="row">
                <div class="col-lg-12 col-centered" id="tweets">
                    
                </div>
            </div>
        </div>
    </div>
</body>

<script>

$('#ex1').slider({
	formatter: function(value) {
		return 'Number of Tweets: ' + value;
	}
});

$( "#submit" ).click(function() {
    if ( $( "#form" ).val() == "") {
        alert("First enter a hashtag and then click search!");
        return
    }
    var width = $('#canvasArea').width();
    var height = $('#canvasArea').height() - 30;

    $('#emotionalToneGraph').remove();
    $("<div class='loader col-centered' id='loader1'></div>").insertAfter( "#graphArea1" );
    $('<canvas class="col-centered" id="emotionalToneGraph" width="' + width + '" height="' + height + '"></canvas>').insertAfter("#loader1");

    $('#languageToneGraph').remove();
    $("<div class='loader col-centered' id='loader2'></div>").insertAfter( "#graphArea2" );
    $('<canvas class="col-centered" id="languageToneGraph" width="' + width + '" height="' + height + '"></canvas>').insertAfter("#loader2");

    $('#socialToneGraph').remove();
    $("<div class='loader col-centered' id='loader3'></div>").insertAfter( "#graphArea3" );
    $('<canvas class="col-centered" id="socialToneGraph" width="' + width + '" height="' + height + '"></canvas>').insertAfter("#loader3");
    var request = $.ajax({
        url: "twitter.php",
        type: "POST",
        data: {hashtag : $( "#form" ).val(), num : $( "#ex1" ).val(), searchBy : $('input[name=searchBy]:checked', '#searchType').val()},
        dataType: "html"
    });

    request.done(function(msg) {
        var result = eval(msg);
        
        // emotion tone
        var anger = result[0]["tones"][0]["score"];
        var disgust = result[0]["tones"][1]["score"];
        var fear = result[0]["tones"][2]["score"];
        var joy = result[0]["tones"][3]["score"];
        var sadness = result[0]["tones"][4]["score"];

        // language tone
        var analytical = result[1]["tones"][0]["score"];
        var confident = result[1]["tones"][1]["score"];
        var tentative = result[1]["tones"][2]["score"];

        // social tones
        var openness = result[2]["tones"][0]["score"];
        var conscientiousness = result[2]["tones"][1]["score"];
        var extraversion = result[2]["tones"][2]["score"];
        var agreeableness = result[2]["tones"][3]["score"];
        var emotionalRange = result[2]["tones"][4]["score"];

        var ctx = document.getElementById("emotionalToneGraph");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Anger", "Disgust", "Fear", "Joy", "Sadness"],
                datasets: [{
                    label: 'Emotional Tone',
                    data: [anger, disgust, fear, joy, sadness],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        var ctx = document.getElementById("languageToneGraph");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Analytical", "Confident", "Tentative"],
                datasets: [{
                    label: 'Language Tone',
                    data: [analytical, confident, tentative],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        var ctx = document.getElementById("socialToneGraph");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Openness", "Conscientiousness", "Extraversion", "Agreeableness", "Emotional Range"],
                datasets: [{
                    label: 'Social Tone',
                    data: [openness, conscientiousness, extraversion, agreeableness, emotionalRange],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        var innerText = "";
        for (var tweetKey in result[3]["tweets"]) {
            var tweet = result[3]["tweets"][tweetKey];
            var html = '<div class="panel"> <div class="panel-body"> ' + tweet + ' <br> </div> </div> <br>';
            innerText += html;
        }
        $("#tweets").html(innerText);

        $('#loader1').remove();
        $('#loader2').remove();
        $('#loader3').remove();
    });

    request.fail(function(jqXHR, textStatus) {
        alert( "Request failed: " + textStatus );
    });
});
</script>

</html>